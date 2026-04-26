<?php

namespace App\Livewire;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class GameBetsView extends Component
{
    public Collection $bets;

    public int $gameId;

    public function mount(int $gameId)
    {
        $this->gameId = $gameId;
        $this->bets = $this->loadBets();
    }

    public function loadBets()
    {
        return Game::where('id', $this->gameId)->firstOrFail()->validatedPlacedBets()->get();
    }

    #[On('updateBetReactions.{gameId}')]
    public function updateBetReactions()
    {
        $this->bets = $this->loadBets();
    }

    public function render()
    {
        return view('livewire.game-bets-view');
    }
}
