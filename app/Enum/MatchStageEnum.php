<?php

namespace App\Enum;

enum MatchStageEnum: string
{
    case Final = 'FINAL';
    case THIRD_PLACE = 'THIRD_PLACE';
    case SEMI_FINALS = 'SEMI_FINALS';
    case QUARTER_FINALS = 'QUARTER_FINALS';
    case LAST_16 = 'LAST_16';
    case LAST_32 = 'LAST_32';
    case LAST_64 = 'LAST_64';
    case GROUP_STAGE = 'GROUP_STAGE';

    public static function fromApi(string $status): self
    {
        return match ($status) {
            'Final' => self::Final,
            'Third Place' => self::THIRD_PLACE,
            'Semi Finals' => self::SEMI_FINALS,
            'Quarter Finals' => self::QUARTER_FINALS,
            'Last 16' => self::LAST_16,
            'Last 32' => self::LAST_32,
            'Last 64' => self::LAST_64,
            'Group Stage' => self::GROUP_STAGE,
        };
    }

    public function translationKey(): string
    {
        return 'enums.match_stage.'.$this->value;
    }

    public function label(): string
    {
        return __($this->translationKey());
    }
}
