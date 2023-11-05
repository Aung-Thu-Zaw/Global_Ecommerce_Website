<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Township>
 */
class TownshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'city_id' => fake()->numberBetween(1, 80),
            'name' => fake()->unique()->sentence(),
            'slug' => fake()->unique()->slug(),
            'created_at' => fake()->dateTimeBetween('-2 months', now()),
        ];
    }
}
