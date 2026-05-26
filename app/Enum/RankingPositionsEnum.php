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
            2 => 'images/position-2.png',
            3 => 'images/position-3.jpeg',
            4 => 'images/position-4.jpeg',
            5 => 'images/position-5.png',
            6 => 'images/position-6.jpg',
            7 => 'images/position-7.jpeg',
            default => 'nada',
        };
    }

    public static function getPositionName(int $position): string
    {
        return match ($position) {
            1 => 'nomade raiz',
            2 => 'petista do job',
            3 => 'banana leitada',
            4 => 'chimpa',
            5 => 'burn',
            6 => 'acorda cara',
            7 => 'peixe linguiço',
            default => '--',
        };
    }
}
