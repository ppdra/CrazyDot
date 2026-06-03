<?php

namespace App\Console\Commands;

use App\Exports\DatabaseBackupExport;
use Illuminate\Console\Command;
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
        $filename = 'backups/backup_' . now()->format('Y-m-d H:i:s') . '.xlsx';

        Excel::store(new DatabaseBackupExport, $filename, 'local');

        $this->info("✅ Backup criado: storage/app/{$filename}");
    }
}
