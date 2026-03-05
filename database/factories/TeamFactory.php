<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
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
            'name' => fake()->randomElement(['Brazil', 'Argentina', 'Germany', 'France', 'Spain', 'Italy']),
            'logo_url' => fake()->unique()->imageUrl(),
            'slug' => fake()->slug(),
        ];
    }
}
