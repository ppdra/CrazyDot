<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    /** @use HasFactory<\Database\Factories\GameResultFactory> */
    use HasFactory;

    public function result()
    {
        return $this->belongsTo(Result::class);
    }
}
