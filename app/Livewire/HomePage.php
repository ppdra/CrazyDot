<?php

namespace App\Livewire;

use App\Enum\MatchStatusEnum;
use App\Models\Game;
use App\Models\Ranking;
use Livewire\Component;

class HomePage extends Component
{
    public ?Ranking $rankingFirstPlace;

    public int $totalPoints;

    public function mount()
    {
        $this->rankingFirstPlace = Ranking::orderBy('position')->first();
        $this->totalPoints = Game::where('status', MatchStatusEnum::FINISHED)->count() * 7;
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
