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
            "brand_id"=>fake()->numberBetween(1, 50),
            "collection_id"=>fake()->numberBetween(1, 30),
            "category_id"=>fake()->numberBetween(1, 69),
            "user_id"=>fake()->numberBetween(3, 103),
            "name"=>fake()->unique()->sentence(),
            "slug"=>fake()->unique()->slug(),
            "image"=>fake()->imageUrl(),
            "code"=>fake()->numberBetween(100, 999),
            "qty"=>fake()->numberBetween(10, 100),
            "price"=>fake()->numberBetween(100, 1500),
            "discount"=>fake()->numberBetween(50, 500),
            "description"=>fake()->paragraph(20),
            "hot_deal"=>fake()->randomElement([true,false]),
            "featured"=>fake()->randomElement([true,false]),
            "special_offer"=>fake()->randomElement([true,false]),
            "status"=>fake()->randomElement(["active","inactive"]),
            "created_at"=>fake()->dateTimeBetween("-4 months", now()),
    ];
    }
}
