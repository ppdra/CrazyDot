<?php

namespace App\Enum;

enum MatchGroupEnum: string
{
    case GROUP_A = 'GROUP_A';
    case GROUP_B = 'GROUP_B';
    case GROUP_C = 'GROUP_C';
    case GROUP_D = 'GROUP_D';
    case GROUP_E = 'GROUP_E';
    case GROUP_F = 'GROUP_F';
    case GROUP_G = 'GROUP_G';
    case GROUP_H = 'GROUP_H';
    case GROUP_I = 'GROUP_I';
    case GROUP_J = 'GROUP_J';
    case GROUP_K = 'GROUP_K';
    case GROUP_L = 'GROUP_L';

    public function translationKey(): string
    {
        return 'enums.match_group.' . $this->value;
    }

    public function label(): string
    {
        return __($this->translationKey());
    }
}
