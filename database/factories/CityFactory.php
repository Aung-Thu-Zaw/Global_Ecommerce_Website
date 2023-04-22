<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "region_id"=>fake()->numberBetween(1, 30),
            "name"=>fake()->unique()->city(),
            "slug"=>fake()->unique()->slug(),
            "created_at"=>fake()->dateTimeBetween("-2 months", now()),
        ];
    }
}
