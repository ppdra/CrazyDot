<?php

namespace App\View\Components;

use App\Enum\MatchStatusEnum;
use App\Models\Game;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MatchBadgeStatus extends Component
{
    public Game $match;

    public array $badgeInfos = [];

    /**
     * Create a new component instance.
     */
    public function __construct(Game $match)
    {
        $this->match = $match;
        $this->badgeInfos = $this->buildStatusLabel();
    }

    public function getRemainingTime(): int
    {
        return Carbon::now()->diffInMinutes($this->match->utc_date);
    }

    public function buildStatusLabel(): array
    {
        if ($this->match->status === MatchStatusEnum::LIVE) {
            return ['color' => 'red', 'label' => 'Live'];
        }

        if ($this->match->status === MatchStatusEnum::FINISHED) {
            return ['color' => 'gray', 'label' => 'Finished'];
        }

        $diff = $this->getRemainingTime();

        return match (true) {
            $diff < 0 => ['color' => 'red', 'label' => 'Live'],
            $diff <= 30 => ['color' => 'yellow', 'label' => 'Starting Soon'],
            $diff <= 60 => ['color' => 'blue', 'label' => 'Today'],

            default => ['color' => 'purple', 'label' => 'Upcoming'],
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.match-badge-status');
    }
}
