<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\App;

class Datetime
{
    public static function datetime(?Carbon $dt): string
    {
        if (! $dt) return '--';

        $tz ??= session('tz');

        return match (App::getLocale()) {
            'pt_BR' => $dt->tz($tz)->translatedFormat('d/m/Y H:i'),
            default => $dt->tz($tz)->translatedFormat('M d, Y h:i A'),
        };
    }
}
