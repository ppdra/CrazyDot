<?php

namespace App\Livewire;

use App\Models\Ranking;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class HomePageRanking extends Component
{
    public Collection $rankings;

    public function mount()
    {
        $this->rankings = Ranking::orderBy('position')->limit(3)->get();

        $this->dispatch('rankingUpdated', firstPlace: $this->rankings->first());
    }

    public function render()
    {
        return view('livewire.home-page-ranking');
    }
}
