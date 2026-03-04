<?php

namespace App\Models;

use App\Enum\ReactionEmoji;
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
