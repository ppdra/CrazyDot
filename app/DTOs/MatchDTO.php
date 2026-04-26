<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enum\MatchGroupEnum;
use App\Enum\MatchStageEnum;
use App\Enum\MatchStatusEnum;
use Carbon\Carbon;

final class MatchDTO
{
    public function __construct(
        public readonly int $externalId,
        public readonly ?int $externalHomeId,
        public readonly ?int $externalAwayId,
        public readonly ?MatchGroupEnum $group,
        public readonly ?int $matchday,
        public readonly ?MatchStageEnum $stage,
        public readonly Carbon $utcDate,
        public readonly MatchStatusEnum $status,
        public readonly ?int $homeScore,
        public readonly ?int $awayScore,
    ) {}

    public static function fromApi(object $match): self
    {
        return new self(
            externalId: $match->id,
            externalHomeId: $match->homeTeam['id'] ?? null,
            externalAwayId: $match->awayTeam['id'] ?? null,
            group: $match->group ? MatchGroupEnum::tryFrom($match->group) : null,
            matchday: $match->matchday ?? null,
            stage: MatchStageEnum::tryFrom($match->stage) ?? null,
            utcDate: Carbon::parse($match->utcDate)->utc(),
            status: MatchStatusEnum::fromApi($match->status),
            homeScore: $match->score['fullTime']['home'] ?? null,
            awayScore: $match->score['fullTime']['away'] ?? null,
        );
    }
}
