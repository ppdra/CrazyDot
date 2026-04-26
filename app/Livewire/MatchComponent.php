<?php

namespace App\Livewire;

use App\Enum\MatchStatusEnum;
use App\Models\Bet;
use App\Models\Game;
use App\Models\Result;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MatchComponent extends Component
{
    public Game $match;

    public int $realHomeScore = 0;

    public int $realAwayScore = 0;

    public int $homeScore = 0;

    public int $awayScore = 0;

    public $userBet;

    public bool $betIsPlaced = false;

    public function mount(Game $match)
    {
        $this->match = $match;

        $userBet = $this->latestValidUserBet();

        if ($userBet) {
            $this->homeScore = $userBet->result->home_score;
            $this->awayScore = $userBet->result->away_score;
            $this->betIsPlaced = true;
        }

        if ($match->gameResult()->exists()) {
            $this->realHomeScore = $match->gameResult->result->home_score;
            $this->realAwayScore = $match->gameResult->result->away_score;
        }
    }

    public function latestValidUserBet()
    {
        return Bet::where('user_id', Auth::user()->id)
            ->where('game_id', $this->match->id)
            ->where('status', true)
            ->first();
    }

    // public function getRemainingTime(): int
    // {
    //     return Carbon::now()->diffInMinutes($this->match->utc_date);
    // }

    // public function shouldPoll(): bool
    // {
    //     $diff = $this->getRemainingTime();

    //     return $this->match->status === MatchStatusEnum::LIVE || ($diff !== null && $diff <= 90 && $diff >= -180);
    // }

    public function incrementScore($team)
    {
        match ($team) {
            'home' => $this->homeScore = min(20, $this->homeScore + 1),
            'away' => $this->awayScore = min(20, $this->awayScore + 1),
            default => null,
        };
    }

    public function decrementScore($team)
    {
        match ($team) {
            'home' => $this->homeScore = max(0, $this->homeScore - 1),
            'away' => $this->awayScore = max(0, $this->awayScore - 1),
            default => null,
        };
    }

    public function saveUserBet()
    {
        try {
            $isValid = $this->match->utc_date->isFuture();
            DB::transaction(function () use ($isValid) {
                $result = Result::updateOrCreate([
                    'home_score' => $this->homeScore,
                    'away_score' => $this->awayScore,
                ]);

                $obs = $isValid ? null : 'Bet placed after match start time';
                Bet::updateOrCreate(
                    [
                        'user_id' => Auth::user()->id,
                        'game_id' => $this->match->id,
                        'status' => $isValid,
                    ],
                    [
                        'result_id' => $result->id,
                        'status' => $isValid,
                        'obs' => $obs,
                    ]
                );
            });

            if ($isValid) {
                $this->betIsPlaced = true;
            }

            $isValid ?
                $this->dispatch(
                    'notify',
                    type: 'success',
                    content: __('notifications.bet_saved'),
                    duration: 4000
                ) : $this->dispatch(
                    'notify',
                    type: 'error',
                    content: __('notifications.bet_error'),
                    duration: 4000
                );
            $this->dispatch('$refresh');
        } catch (Exception $e) {
            Log::error(self::class.' - Error saving user bet', ['error' => $e->getMessage()]);
            $this->dispatch(
                'notify',
                type: 'error',
                content: __('notifications.bet_error'),
                duration: 4000
            );
        }
    }

    public function removeUserBet()
    {
        try {
            $isValid = $this->match->utc_date->isFuture();
            DB::transaction(function () use ($isValid) {
                $obs = $isValid ? 'Bet removed by user' : 'Try removing bet after match start time';

                $bet = Bet::where('user_id', Auth::user()->id)
                    ->where('game_id', $this->match->id)
                    ->where('status', true)
                    ->first();

                if (! $isValid) {
                    $bet->update([
                        'status' => false,
                        'obs' => $obs,
                    ]);

                    return;
                }

                $bet->update([
                    'status' => false,
                    'obs' => $obs,
                ]);

            });

            if ($isValid) {
                $this->betIsPlaced = false;
            }

            $isValid ?
                $this->dispatch(
                    'notify',
                    type: 'success',
                    content: __('notifications.bet_removed'),
                    duration: 4000
                ) : $this->dispatch(
                    'notify',
                    type: 'error',
                    content: __('notifications.bet_remove_error'),
                    duration: 4000
                );
        } catch (Exception $e) {
            Log::error(self::class.' - Error removing user bet', ['error' => $e->getMessage()]);
            $this->dispatch(
                'notify',
                type: 'error',
                content: __('notifications.bet_remove_error'),
                duration: 4000
            );
        }
    }

    public function render()
    {
        return view('livewire.match-component');
    }
}
