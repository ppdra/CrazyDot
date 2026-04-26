<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Team;
use App\Services\Apis\FootballDataOrg\ApiService;
use Illuminate\Console\Command;

class InsertMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:insert-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get matches from Football Data API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $matches = ApiService::getMatches();

        $payload = collect($matches)->map(fn ($m) => [
            'external_id' => $m->externalId,
            'home_id' => Team::where('external_id', $m->externalHomeId)->value('id') ?? null,
            'away_id' => Team::where('external_id', $m->externalAwayId)->value('id') ?? null,
            'group_name' => $m->group,
            'matchday' => $m->matchday,
            'stage' => $m->stage,
            'utc_date' => $m->utcDate,
            'status' => $m->status,
            'updated_at' => now(),
            'created_at' => now(),
        ])->all();

        Game::query()->upsert(
            $payload,
            ['external_id'],
            ['home_id', 'away_id', 'group_name', 'matchday', 'stage', 'utc_date', 'status', 'updated_at']
        );

    }
}
