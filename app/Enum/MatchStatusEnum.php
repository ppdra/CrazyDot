<?php

namespace App\Enum;

enum MatchStatusEnum: string
{
    case LIVE = 'LIVE';
    case FINISHED = 'FINISHED';
    case SCHEDULED = 'SCHEDULED';
    case CANCELLED = 'CANCELLED';
    case PAUSED = 'PAUSED';
    case POSTPONED = 'POSTPONED';
    case SUSPENDED = 'SUSPENDED';

    public static function fromApi(string $status): self
    {
        return match ($status) {
            'IN_PLAY' => self::LIVE,
            'FINISHED' => self::FINISHED,
            'SCHEDULED' => self::SCHEDULED,
            'TIMED' => self::SCHEDULED,
            'CANCELLED' => self::CANCELLED,
            'PAUSED' => self::PAUSED,
            'POSTPONED' => self::POSTPONED,
            'SUSPENDED' => self::SUSPENDED,
            default => throw new \InvalidArgumentException("Unknown match status: $status"),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LIVE => 'red-500',
            self::FINISHED => 'green-500',
            self::SCHEDULED => 'blue-500',
            self::CANCELLED => 'gray-500',
            self::PAUSED => 'yellow-500',
            self::POSTPONED => 'orange-500',
            self::SUSPENDED => 'purple-500',
        };
    }

    public function translationKey(): string
    {
        return 'enums.match_status.'.$this->value;
    }

    public function label(): string
    {
        return __($this->translationKey());
    }
}
