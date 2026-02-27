<?php

namespace App\Livewire;

use App\Enum\MatchStatusEnum;
use App\Models\Game;
use App\Models\Ranking;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class RankingPage extends Component
{

    public Collection $rankings;
    public int $totalPoints;

    public function mount()
    {
        $this->rankings = Ranking::orderBy('position')->get();
        $this->totalPoints = Game::where('status', MatchStatusEnum::FINISHED)->count() * 7;
    }

    public function render()
    {
        return view('livewire.ranking-page');
    }
}
