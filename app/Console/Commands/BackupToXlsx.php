<?php

namespace App\Console\Commands;

use App\Exports\DatabaseBackupExport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class BackupToXlsx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:backup-to-xlsx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup do banco de dados para arquivo xlsx';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dt = now()->format('Y-m-d H:i:s');
        $token = config('services.telegram.token');
        $filename = 'backups/backup_' . $dt . '.xlsx';

        Excel::store(new DatabaseBackupExport, $filename, 'local');

        Http::attach(
            'document',
            file_get_contents("storage/app/private/{$filename}"),
            "report{$dt}.xlsx"
        )->post(
            "https://api.telegram.org/bot{$token}/sendDocument",
            [
                'chat_id' => config('services.telegram.chat_id'),
                'text' => 'Deploy concluído com sucesso!',
            ]
        );

        $this->info("✅ Backup criado: storage/app/{$filename}");
    }
}


