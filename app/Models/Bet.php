<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    /** @use HasFactory<\Database\Factories\BetFactory> */
    use HasFactory;


    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function points()
    {
        return $this->hasOne(UserPoint::class, 'bet_id');
    }   
}
