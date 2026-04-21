<?php

namespace App\Livewire;

use App\Enum\MatchGroupEnum;
use App\Enum\MatchStageEnum;
use App\Enum\MatchStatusEnum;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MatchesList extends Component
{
    use WithPagination;

    public array $countryOptsList;
    public array $groupOptsList;
    public array $stageOptsList;
    public array $statusOptsList;
    public array $selectedCountry;
    public array $selectedStatus;
    public array $selectedGroup;

    public string $selectedStage;
    public string $selectedBetIsPlaced;


    public function mount()
    {
        $this->countryOptsList = $this->getCountryOptsList();
        $this->groupOptsList = MatchGroupEnum::cases();
        $this->stageOptsList = MatchStageEnum::cases();
        $this->statusOptsList = MatchStatusEnum::cases();

        $this->selectedStatus = [MatchStatusEnum::SCHEDULED->value];
    }

    public function updatedSelectedCountry(): void
    {
        $this->loadGames();
    }
    public function updatedSelectedGroup(): void
    {
        $this->loadGames();
    }
    public function updatedSelectedStage(): void
    {
        $this->loadGames();
    }
    public function updatedSelectedStatus(): void
    {
        $this->loadGames();
    }

    private function loadGames()
    {
        return Game::query()
            ->with(['homeTeam', 'awayTeam', 'gameResult', 'bets.result'])
            ->when($this->selectedCountry ?? null, function ($q) {
                $q->where(function ($qq) {
                    $qq->whereIn('home_id', $this->selectedCountry)
                        ->orWhereIn('away_id', $this->selectedCountry);
                });
            })
            ->when($this->selectedBetIsPlaced ?? null, function ($q) {
                if ($this->selectedBetIsPlaced === 'true') {
                    $q->whereHas('bets', function ($betQuery) {
                        $betQuery
                            ->where('user_id', Auth::user()->id)
                            ->where('status', true);
                    });
                } else {
                    $q->whereDoesntHave('bets', function ($betQuery) {
                        $betQuery
                            ->where('user_id', Auth::user()->id)
                            ->where('status', true);
                    });
                }
            })
            ->when($this->selectedStatus ?? null, fn($q) => $q->whereIn('status', $this->selectedStatus))
            ->when($this->selectedGroup ?? null, fn($q) => $q->whereIn('group_name', $this->selectedGroup))
            ->when($this->selectedStage ?? null, fn($q) => $q->where('stage', $this->selectedStage))
            ->orderBy('utc_date')
            ->get();
    }

    // todo refactor to use cache
    public function getCountryOptsList(): array
    {
        return Team::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }



    public function render()
    {
        $gamesList = $this->loadGames();

        return view('livewire.matches-list', compact('gamesList'));
    }
}
