<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TableSheetExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(private string $table) {}

    public function collection()
    {
        return DB::table($this->table)->get()->map(fn ($row) => (array) $row);
    }

    public function headings(): array
    {
        return array_keys((array) DB::table($this->table)->first());
    }

    public function title(): string
    {
        return $this->table;
    }
}
