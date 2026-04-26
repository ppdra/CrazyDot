<?php

namespace App\Livewire;

use App\Enum\MatchStatusEnum;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class LiveMatches extends Component
{
    public Collection $liveGames;

    public function render()
    {
        $this->liveGames = Game::where('status', MatchStatusEnum::LIVE)
            ->orderBy('utc_date')
            ->get();

        return view('livewire.live-matches');
    }
}
