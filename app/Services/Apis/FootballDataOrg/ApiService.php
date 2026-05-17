<?php

declare(strict_types=1);

namespace App\Services\Apis\FootballDataOrg;

use App\DTOs\MatchDTO;
use App\DTOs\TeamDTO;
use Illuminate\Support\Facades\Http;

class ApiService
{
    public static function getTeams(): array
    {
        $response = Http::withHeader('X-Auth-Token', config('services.football_data.key'))
            ->get(config('services.football_data.url').'/competitions/CL/teams')
            ->throw()
            ->json();

        return collect($response['teams'])
            ->map(fn ($team) => TeamDTO::fromApi((object) $team))
            ->all();
    }

    public static function getMatches($urlQuery = null): array
    {
        $response = Http::withHeader('X-Auth-Token', config('services.football_data.key'))
            ->get(config('services.football_data.url').'/competitions/CL/matches'.$urlQuery)
            ->throw()
            ->json();

        return collect($response['matches'])
            ->map(fn ($match) => MatchDTO::fromApi((object) $match))
            ->all();
    }
}
