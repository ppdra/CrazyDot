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

        if (! file_exists($file)) {
            $this->error("Ficheiro não encontrado: {$file}");

            return 1;
        }

        $this->warn('⚠️  Isto vai substituir todos os dados da DB!');

        if (! $this->confirm('Confirmas o restore?')) {
            $this->info('Cancelado.');

            return 0;
        }

        $db = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        // descomprime se for .gz
        if (str_ends_with($file, '.gz')) {
            $sqlFile = str_replace('.gz', '', $file);
            exec("gunzip -c {$file} > {$sqlFile}");
        } else {
            $sqlFile = $file;
        }

        exec("mysql -h {$host} -u {$user} -p{$pass} {$db} < {$sqlFile}");

        $this->info('✅ Restore concluído.');

        return 0;
    }
}
