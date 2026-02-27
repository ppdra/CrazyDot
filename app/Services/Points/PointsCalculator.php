<?php

declare(strict_types=1);

namespace App\Services\Points;

use App\Models\Game;
use App\Models\Ranking;
use App\Models\UserPoint;
use Illuminate\Support\Facades\DB;

class PointsCalculator
{

    public function calculateMatchPoints(Game $game): void
    {
        $realResult = $game->gameResult->result;

        $usersBets = $game->validatedPlacedBets()->get();

        foreach ($usersBets as $bet) {
            $points = $this->calculateBetPoints($bet, $realResult);
            $this->insertPointsForGame($game, $points, $bet);
        }

        // calculate streaks for users.
        $this->calculateStreaks($game);

        // calculate ranking positions
        $this->calculateRankingPositions();
    }

    private function calculateBetPoints($bet, $realResult): int
    {

        $points = 0;

        // Exact score
        if ($bet->result_id === $realResult->id) {
            return 7;
        }

        $betWinner = $bet->result->home_score > $bet->result->away_score ? 'home' : ($bet->result->home_score < $bet->result->away_score ? 'away' : 'draw');

        $gameWinner = $realResult->home_score > $realResult->away_score ? 'home' : ($realResult->home_score < $realResult->away_score ? 'away' : 'draw');

        // Correct team winner
        if ($betWinner === $gameWinner) {
            $points += 3;
        }

        if ($bet->result->home_score === $realResult->home_score || $bet->result->away_score === $realResult->away_score) {
            $points += 2;
        }

        return $points;
    }

    private function insertPointsForGame(Game $game, int $points, $bet): void
    {
        UserPoint::updateOrCreate(
            [
                'user_id' => $bet->user_id,
                'game_id' => $game->id,
            ],
            [
                'points' => DB::raw("points + $points"),
                'bet_id' => $bet->id,
                'game_result_id' => $game->gameResult->id,
            ]
        );
    }

    private function calculateStreaks(Game $game): void
    {
        $usersPoints = $game->userPoints()->get();

        foreach ($usersPoints as $userPoint) {
            $points = $userPoint->points;

            DB::transaction(function () use ($points, $userPoint) {

                $userRanking = Ranking::firstOrCreate(
                    ['user_id' => $userPoint->user_id],
                    [
                        'current_full_points_streak' => 0,
                        'best_full_points_streak' => 0,
                        'current_non_points_streak' => 0,
                        'best_non_points_streak' => 0,
                    ]
                );

                $userRanking->points += $points;

                if ($points === 0) {
                    $userRanking->current_full_points_streak = 0;
                    $userRanking->current_non_points_streak += 1;

                    if ($userRanking->current_non_points_streak > $userRanking->best_non_points_streak) {
                        $userRanking->best_non_points_streak = $userRanking->current_non_points_streak;
                    }

                    $userRanking->save();
                    return;
                }

                if ($points === 7) {
                    $userRanking->current_non_points_streak = 0;
                    $userRanking->current_full_points_streak += 1;

                    if ($userRanking->current_full_points_streak > $userRanking->best_full_points_streak) {
                        $userRanking->best_full_points_streak = $userRanking->current_full_points_streak;
                    }

                    $userRanking->save();
                    return;
                }

                $userRanking->current_full_points_streak = 0;
                $userRanking->current_non_points_streak = 0;

                $userRanking->save();
            });
        };
    }

    private function calculateRankingPositions(): void
    {
        $rankings = Ranking::orderByDesc('points')->get();

        $position = 1;
        foreach ($rankings as $ranking) {
            $ranking->last_position = $ranking->position ?? 1;
            $ranking->position = $position++;
            $ranking->save();
        }
    }
}
