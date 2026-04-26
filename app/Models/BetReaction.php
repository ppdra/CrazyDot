<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetReaction extends Model
{
    /** @use HasFactory<\Database\Factories\BetReactionFactory> */
    use HasFactory;

    public function casts()
    {
        return [
            'emoji_id' => 'integer',
        ];
    }
}
