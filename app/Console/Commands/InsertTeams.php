<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Services\Apis\FootballDataOrg\ApiService;
use Illuminate\Console\Command;

class InsertTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:insert-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get teams from Football Data API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $teams = ApiService::getTeams();

        $payload = collect($teams)->map(fn ($t) => [
            'external_id' => $t->externalId,
            'name' => $t->name,
            'slug' => $t->slug,
            'logo_url' => $t->logoUrl,
            'updated_at' => now(),
            'created_at' => now(),
        ])->all();

        Team::query()->upsert(
            $payload,
            ['external_id'],
            ['name', 'slug', 'logo_url', 'updated_at']
        );
    }
}
