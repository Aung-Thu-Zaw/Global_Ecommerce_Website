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
            "brand_id"=>fake()->numberBetween(1, 8),
            "sub_category_id"=>fake()->numberBetween(1, 8),
            "user_id"=>2,
            "name"=>fake()->name(),
            "slug"=>fake()->slug(),
            "image"=>fake()->imageUrl(),
            "code"=>fake()->numberBetween(100, 999),
            "qty"=>fake()->numberBetween(10, 100),
            // "tag"=>fake()->,
            // "size"=>fake()->,
            "color"=>fake()->hexColor(),
            "price"=>fake()->numberBetween(10, 10000),
            // "discount"=>fake()->,
            "description"=>fake()->paragraph(),
            // "hot_deal"=>fake()->,
            // "featured"=>fake()->,
            // "special_offer"=>fake()->,
            "created_at"=>fake()->dateTimeBetween("-4 months", now()),
        ];
    }
}
