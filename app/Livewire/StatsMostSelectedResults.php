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
                    $q2->where('status', MatchStatusEnum::FINISHED);
                });
            })
            ->withCount('bets')
            ->orderByDesc('bets_count')
            ->get()
            ->toArray();
    }

    public function updatedSelectedResult()
    {
        if (!$this->selectedResult) {
            $this->labels = [];
            $this->data = [];
            $this->total = 0;
            return;
        }

        $players = Bet::query()
            ->join('users', 'bets.user_id', '=', 'users.id')
            ->where('bets.result_id', $this->selectedResult)
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
