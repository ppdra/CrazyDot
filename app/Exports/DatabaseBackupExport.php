<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DatabaseBackupExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'users' => new TableSheetExport('users'),
            'teams' => new TableSheetExport('teams'),
            'games' => new TableSheetExport('games'),
            'results' => new TableSheetExport('results'),
            'game_results' => new TableSheetExport('game_results'),
            'bets' => new TableSheetExport('bets'),
            'user_points' => new TableSheetExport('user_points'),
            'rankings' => new TableSheetExport('rankings'),
            'bet_reactions' => new TableSheetExport('bet_reactions'),
        ];
    }
}
