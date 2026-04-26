<?php

namespace App\Livewire;

use App\Enum\MatchStatusEnum;
use App\Models\Bet;
use App\Models\Result;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatsMostSelectedResults extends Component
{
    public array $results = [];

    public ?string $selectedResult = null;

    public array $labels = [];

    public array $data = [];

    public array $colors = [];

    public int $total = 0;

    public function mount()
    {
        $this->results = Result::query()
            ->whereHas('bets', function ($q) {
                $q->where('status', true);
                $q->whereHas('game', function ($q2) {
                    // $q2->where('status', MatchStatusEnum::FINISHED);
                });
            })
            ->withCount('bets')
            ->orderByDesc('bets_count')
            ->get()
            ->toArray();

        $this->results = Result::query()
            ->whereHas('bets', function ($q) {
                $q->where('status', true);
                $q->whereHas('game', function ($q2) {
                    // $q2->where('status', MatchStatusEnum::FINISHED);
                });
            })
            ->selectRaw("
        LEAST(home_score, away_score) as min_score,
        GREATEST(home_score, away_score) as max_score,
        CONCAT(GREATEST(home_score, away_score), 'x', LEAST(home_score, away_score)) as normalized_result
    ")

            ->groupBy('home_score', 'away_score')
            ->orderBy('home_score')
            ->get()
            ->unique('normalized_result')
            ->toArray();
    }

    private function getEquivalentResultIds(string $result): array
    {
        [$a, $b] = explode('x', $result);

        return Result::query()
            ->where(function ($q) use ($a, $b) {
                $q->where([
                    ['home_score', $a],
                    ['away_score', $b],
                ])->orWhere([
                    ['home_score', $b],
                    ['away_score', $a],
                ]);
            })
            ->pluck('id')
            ->toArray();
    }

    public function updatedSelectedResult()
    {
        if (! $this->selectedResult) {
            $this->labels = [];
            $this->data = [];
            $this->total = 0;

            return;
        }

        $resultIds = $this->getEquivalentResultIds($this->selectedResult);

        $players = Bet::query()
            ->join('users', 'bets.user_id', '=', 'users.id')
            ->whereIn('bets.result_id', $resultIds)
            ->where('bets.status', true)
            ->select(
                'users.name as name',
                'users.color as color',
                DB::raw('COUNT(bets.id) as count')
            )
            ->groupBy('users.id', 'users.name', 'users.color')
            ->orderByDesc('count')
            ->get();

        $this->labels = $players->pluck('name')->toArray();
        $this->data = $players->pluck('count')->toArray();

        $this->total = $players->sum('count');

        $this->colors = $players->pluck('color')->toArray();
    }

    public function render()
    {
        return view('livewire.stats-most-selected-results');
    }
}
