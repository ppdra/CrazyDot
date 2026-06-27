<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Ranking;
use App\Models\UserPoint;
use App\Enum\MatchStatusEnum;
use App\Services\Points\PointsCalculator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculateAllPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:recalculate-all-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate all points and rankings from scratch based on existing bets and game results in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting full recalculation of points and rankings...');

        DB::transaction(function () {

            // Step 1: Delete all UserPoints (will be fully recalculated)
            $deletedPoints = UserPoint::query()->delete();
            $this->info("Deleted {$deletedPoints} UserPoint records.");

            // Step 2: Reset all Ranking stats (keep users, zero everything out)
            $resetRankings = Ranking::query()->update([
                'points'                     => 0,
                'position'                   => null,
                'last_position'              => null,
                'current_full_points_streak' => 0,
                'best_full_points_streak'    => 0,
                'current_non_points_streak'  => 0,
                'best_non_points_streak'     => 0,
            ]);
            $this->info("Reset {$resetRankings} Ranking records.");

            // Step 3: Fetch all finished games that have a result, ordered by date ascending
            $games = Game::where('status', MatchStatusEnum::FINISHED)
                ->whereHas('gameResult')
                ->orderBy('utc_date')
                ->get();

            $this->info("Found {$games->count()} finished games with results to process.");

            $calculator = app(PointsCalculator::class);
            $bar = $this->output->createProgressBar($games->count());
            $bar->start();

            foreach ($games as $game) {
                $calculator->calculateMatchPoints($game);
                $bar->advance();
            }

            $bar->finish();
        });

        $this->newLine();
        $this->info('Recalculation complete!');
    }
}