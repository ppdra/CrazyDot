<?php

namespace App\Livewire;

use App\Models\UserPoint;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class LastResults extends Component
{
    public Collection $lastResults;

    public function mount()
    {
        $this->lastResults = UserPoint::orderBy('created_at', 'desc')->limit(7)->get();
    }

    public function render()
    {
        return view('livewire.last-results');
    }
}
