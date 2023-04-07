<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
    */
    public function definition()
    {
        return [
            "brand_id"=>1,
            "collection_id"=>fake()->numberBetween(1, 20),
            "category_id"=>fake()->numberBetween(1, 8),
            "user_id"=>2,
            "name"=>fake()->unique()->name(),
            "slug"=>fake()->unique()->slug(),
            "image"=>fake()->imageUrl(),
            "code"=>fake()->numberBetween(100, 999),
            "qty"=>fake()->numberBetween(10, 100),
            "price"=>fake()->numberBetween(10, 10000),
            "discount"=>fake()->numberBetween(5, 50),
            "description"=>fake()->paragraph(),
            "hot_deal"=>false,
            "featured"=>false,
            "special_offer"=>false,
            "created_at"=>fake()->dateTimeBetween("-4 months", now()),
        ];
    }
}
