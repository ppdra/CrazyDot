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
            1 => 'images/position-1.png',
            2 => 'images/position-2.jpeg',
            3 => 'images/position-3.png',
            4 => 'images/position-4.jpeg',
            5 => 'images/position-5.jpeg',
            6 => 'images/position-6.png',
            7 => 'images/position-7.jpeg',
            default => 'nada',
        };
    }

    public static function getPositionName(int $position): string
    {
        return match ($position) {
            1 => 'nomade raiz',
            3 => 'petista do job',
            4 => 'banana leitada',
            5 => 'chimpa',
            6 => 'burn',
            7 => 'peixe linguiço',
            default => '--',
        };
    }
}
