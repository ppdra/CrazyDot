<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Result;
use App\Services\Apis\FootballDataOrg\ApiService;
use App\Services\Points\PointsCalculator;
use Illuminate\Console\Command;

class InsertMatchesAllResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:insert-matches-all-results';

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
        $matches = ApiService::getMatches('?status=FINISHED');
        $calculator = app(PointsCalculator::class);

        foreach ($matches as $match) {
            $game = Game::where('external_id', $match->externalId)->first();

            if (! $game) {
                continue;
            }

            if (! $game->gameResult()->exists()) {
                $result = Result::where('home_score', $match->homeScore)
                    ->where('away_score', $match->awayScore)
                    ->first();

                if (! $result) {
                    $result = Result::create([
                        'home_score' => $match->homeScore ?? null,
                        'away_score' => $match->awayScore ?? null,
                    ]);
                }

                $game->gameResult()->create([
                    'result_id' => $result->id,
                ]);

                // calculate points for bets game.
                $calculator->calculateMatchPoints($game);
            }
        }
    }
}
