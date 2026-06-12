<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RestoreDatabaseFromBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:restore-backup {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("Ficheiro não encontrado: {$file}");
            return 1;
        }

        $this->warn("⚠️  Isto vai substituir todos os dados da DB!");

        if (!$this->confirm('Confirmas o restore?')) {
            $this->info('Cancelado.');
            return 0;
        }

        $db   = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        // directório temporário para extrair
        $tmpDir = storage_path('app/restore_tmp');
        mkdir($tmpDir, 0755, true);

        // 1. Descompacta o .zip
        $this->info('A descompactar o zip...');
        $zip = new \ZipArchive();
        $zip->open($file);
        $zip->extractTo($tmpDir);
        $zip->close();

        // 2. Encontra o .sql dentro do zip
        $sqlFiles = glob("{$tmpDir}/db-dumps/*.sql");

        if (empty($sqlFiles)) {
            $this->error('Nenhum ficheiro .sql encontrado dentro do zip.');
            exec("rm -rf {$tmpDir}");
            return 1;
        }

        $sqlFile = $sqlFiles[0];

        // 3. Importa diretamente (sem gunzip)
        $this->info('A preparar o ficheiro SQL...');
        $sql = file_get_contents($sqlFile);
        $sql = preg_replace('/^SET @@SESSION\.SQL_LOG_BIN.*$/m', '', $sql);
        $sql = preg_replace('/^SET @@GLOBAL\.GTID_PURGED.*$/m', '', $sql);
        file_put_contents($sqlFile, $sql);

        $this->info('A importar para a base de dados...');
        exec("mysql -h {$host} -u {$user} -p{$pass} {$db} < {$sqlFile}");

        // 4. Limpa os temporários
        exec("rm -rf {$tmpDir}");

        $this->info("✅ Restore concluído.");
        return 0;
    }
}
