<?php

namespace App\Livewire;

use App\Enum\MatchStatusEnum;
use App\Models\UserPoint;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatsChartPointsPerDay extends Component
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
                DB::raw('DATE(games.utc_date) as day'),
                DB::raw('SUM(user_points.points) as total')
            )
            ->groupBy('users.id', 'users.name', 'users.color', 'day')
            ->orderByRaw('DATE(games.utc_date)')
            ->get();

        $labels = $rows->pluck('day')->unique()->values();

        $datasets = $rows->groupBy('id')->map(function ($userRows) use ($labels) {
            $user = $userRows->first();

            $data = $labels->map(function ($day) use ($userRows) {
                $row = $userRows->firstWhere('day', $day);
                return $row ? (int) $row->total : 0;
            });

            return [
                'label' => $user->name,
                'data' => $data->values()->toArray(),
                'backgroundColor' => $user->color,
            ];
        });

        $this->labels = $labels->toArray();
        $this->datasets = $datasets->values()->toArray();
    }


    public function render()
    {
        return view('livewire.stats-chart-points-per-day');
    }
}
