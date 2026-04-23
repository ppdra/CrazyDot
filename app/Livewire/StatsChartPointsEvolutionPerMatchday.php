<?php

namespace App\Livewire;

use App\Enum\MatchStatusEnum;
use App\Models\UserPoint;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatsChartPointsEvolutionPerMatchday extends Component
{
    public array $labels = [];
    public array $datasets = [];

    public function mount()
    {
        $this->getData();
    }

    private function getData()
    {
        $rows = UserPoint::query()
            ->join('users', 'users.id', '=', 'user_points.user_id')
            ->join('games', 'games.id', '=', 'user_points.game_id')
            ->where('games.status', MatchStatusEnum::FINISHED)
            ->select(
                'users.id',
                'users.name',
                'users.color',
                DB::raw('games.matchday as matchday'),
                DB::raw('SUM(user_points.points) as total')
            )
            ->groupBy('users.id', 'users.name', 'users.color', 'matchday')
            ->orderBy('matchday')
            ->get();

        $labels = $rows->pluck('matchday')->unique()->values();

        $datasets = $rows->groupBy('id')->map(function ($userRows) use ($labels) {

            $user = $userRows->first();

            $running = 0;

            $data = $labels->map(function ($matchday) use ($userRows, &$running) {
                $row = $userRows->firstWhere('matchday', $matchday);
                $running += $row ? $row->total : 0;
                return $running;
            });

            return [
                'label' => $user->name,
                'data' => $data->values()->toArray(),
                'borderColor' => $user->color,
                'backgroundColor' => $user->color,
                'tension' => 0.4,
                'fill' => false,
            ];
        });

        $this->labels = $labels->toArray();
        $this->datasets = $datasets->values()->toArray();
    }


    public function render()
    {
        return view('livewire.stats-chart-points-evolution-per-matchday');
    }
}
