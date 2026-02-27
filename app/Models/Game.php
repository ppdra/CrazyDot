<?php

namespace App\Models;

use App\Enum\MatchGroupEnum;
use App\Enum\MatchStageEnum;
use App\Enum\MatchStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\MatchesFactory> */
    use HasFactory;

    public function casts()
    {
        return [
            'utc_date' => 'datetime',
            'status' => MatchStatusEnum::class,
            'group_name' => MatchGroupEnum::class,
            'stage' => MatchStageEnum::class,
        ];
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_id');
    }

    public function gameResult()
    {
        return $this->hasOne(GameResult::class);
    }

    public function bets()
    {
        return $this->hasMany(Bet::class, 'game_id');
    }

    public function validatedPlacedBets()
    {
        return $this->hasMany(Bet::class, 'game_id')->where('status', true);
    }

    public function userPoints()
    {
        return $this->hasMany(UserPoint::class, 'game_id');
    }

}
