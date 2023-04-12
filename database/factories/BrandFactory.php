<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name"=>fake()->unique()->company(),
            "slug"=>fake()->unique()->slug(),
            "description"=>fake()->paragraph(20),
            "image"=>fake()->imageUrl(),
            "created_at"=>fake()->dateTimeBetween("-9 months", now()),
        ];
    }
}
