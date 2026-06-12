<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class BackupDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:backup-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup do banco de';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // 1. Corre o backup
        $this->info('A criar backup...');
        $this->call('backup:run', ['--only-db' => true]);

        // 2. Encontra o ficheiro mais recente
        $backupPath = $this->latestBackup();

        if (! $backupPath) {
            $this->error('Nenhum backup encontrado após o run.');

            return 1;
        }

        $this->info("Backup encontrado: {$backupPath}");

        // 3. Envia para o Telegram
        $token = config('services.telegram.token');
        $chatId = config('services.telegram.chat_id');
        $date = now()->format('Y-m-d H:i');

        $response = Http::attach(
            'document',
            file_get_contents($backupPath),
            basename($backupPath)
        )->post("https://api.telegram.org/bot{$token}/sendDocument", [
            'chat_id' => $chatId,
            'caption' => "🗄️ Backup da DB — {$date}",
        ]);

        if ($response->successful()) {
            $this->info('✅ Backup enviado para o Telegram.');
        } else {
            $this->error('❌ Erro ao enviar para o Telegram: '.$response->body());

            return 1;
        }

        return 0;
    }

    private function latestBackup(): ?string
    {
        $appName = str_replace(' ', '\ ', config('app.name'));
        $files = glob(storage_path("app/private/{$appName}/*.zip"));

        if (empty($files)) {
            // tenta sem espaços escapados
            $files = glob(storage_path('app/'.config('app.name').'/*/*/*.sql.gz'));
        }

        if (empty($files)) {
            return null;
        }

        // ordena por data de modificação e retorna o mais recente
        usort($files, fn ($a, $b) => filemtime($b) - filemtime($a));

        return $files[0];
    }
}
