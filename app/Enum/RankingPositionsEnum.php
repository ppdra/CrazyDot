<?php

namespace App\Enum;

enum RankingPositionsEnum: int
{
    case FIRST = 1;
    case SECOND = 2;
    case THIRD = 3;
    case FOURTH = 4;
    case FIFTH = 5;
    case SIXTH = 6;
    case SEVENTH = 7;

    public static function getImgUrlByPositionInt(int $position): string
    {
        return match ($position) {
            1 => 'images/position-1.jpeg',
            2 => 'images/position-2.jpeg',
            default => 'images/position-1.jpeg',
        };
    }

    public static function getPositionName(int $position): string
    {
        return match ($position) {
            7 => 'banana leitada',
            default => '--',
        };
    }
}
