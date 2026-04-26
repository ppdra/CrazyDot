<?php

namespace App\Enum;

enum ReactionEmoji: int
{
    case THUMBS_UP = 1;
    case FIRE = 2;
    case LAUGH = 3;
    case WOW = 4;
    case CRY = 5;
    case HEART = 6;
    case EYES = 7;
    case CLOWN = 8;
    case BOOK = 9;
    case MONKEY = 10;
    case BALL = 11;
    case ZERO = 12;
    case TWO = 13;
    case THREE = 14;
    case FIVE = 15;
    case SEVEN = 16;
    case SHIT = 17;
    case COLD = 18;
    case MILK = 19;

    public function emoji(): string
    {
        return match ($this) {
            self::THUMBS_UP => '👍',
            self::FIRE => '🔥',
            self::LAUGH => '😂',
            self::WOW => '😮',
            self::CRY => '😭',
            self::HEART => '❤️',
            self::EYES => '👀',
            self::CLOWN => '🤡',
            self::BOOK => '📚',
            self::MONKEY => '🦧',
            self::BALL => '⚽',
            self::ZERO => '0️⃣',
            self::TWO => '2️⃣',
            self::THREE => '3️⃣',
            self::FIVE => '5️⃣',
            self::SEVEN => '7️⃣',
            self::SHIT => '💩',
            self::COLD => '🥶',
            self::MILK => '🍼',
        };
    }

    public static function picker(): array
    {
        return array_map(
            fn (self $e) => ['id' => $e->value, 'emoji' => $e->emoji()],
            self::cases()
        );
    }

    public static function emojiFromId(int $id): string
    {
        return self::tryFrom($id)?->emoji() ?? '❓';
    }
}
