<?php

namespace App\Console\Commands;

use App\Enum\MatchStatusEnum;
use App\Models\Game;
use App\Models\Result;
use App\Services\Apis\FootballDataOrg\ApiService;
use App\Services\Points\PointsCalculator;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InsertMatchesResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:insert-matches-results';

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
        $now = Carbon::now()->subDay()->format('Y-m-d');
        $matches = ApiService::getMatches("?status=FINISHED&dateFrom={$now}&dateTo={$now}");
        $calculator = app(PointsCalculator::class);

        foreach ($matches as $match) {
            $game = Game::where('external_id', $match->externalId)->first();
            if ($game->status !== MatchStatusEnum::FINISHED) {
                $game->update([
                    'status' => MatchStatusEnum::FINISHED,
                ]);
            }

            if (!$game->gameResult()->exists()) {
                $result = Result::where('home_score', $match->homeScore)
                    ->where('away_score', $match->awayScore)
                    ->first();

                if (!$result) {
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




