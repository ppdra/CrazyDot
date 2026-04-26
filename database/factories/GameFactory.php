<?php

namespace Database\Factories;

use App\Enum\MatchGroupEnum;
use App\Enum\MatchStageEnum;
use App\Enum\MatchStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => fake()->unique()->numberBetween(1, 1000),
            'home_id' => null,
            'away_id' => null,
            'matchday' => fake()->numberBetween(0, 5),
            'group_name' => fake()->randomElement(MatchGroupEnum::cases())->value,
            'stage' => fake()->randomElement(MatchStageEnum::cases())->value,
            'status' => fake()->randomElement(MatchStatusEnum::cases())->value,
            'utc_date' => fake()->dateTimeBetween('-1 month', '+1 week'),
        ];
    }
}
