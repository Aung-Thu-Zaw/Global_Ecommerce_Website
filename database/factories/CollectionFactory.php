<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collection>
 */
class CollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title"=>fake()->title(),
            "slug"=>fake()->unique()->slug(),
            "image"=>fake()->imageUrl(),
            "created_at"=>fake()->dateTimeBetween("-4 months", now()),
        ];
    }
}
