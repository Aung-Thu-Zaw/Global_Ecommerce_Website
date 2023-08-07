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
            "category_id"=>fake()->numberBetween(1, 67),
            "seller_id"=>fake()->numberBetween(4, 64),
            "name"=>fake()->unique()->sentence(),
            "slug"=>fake()->unique()->slug(),
            "image"=>fake()->imageUrl(),
            "code"=>fake()->randomLetter(),
            "qty"=>fake()->numberBetween(20, 200),
            "price"=>fake()->numberBetween(10, 1000),
            "discount"=>fake()->numberBetween(50, 500),
            "description"=>fake()->paragraph(20),
            // "hot_deal"=>fake()->randomElement([true,false]),
            // "featured"=>fake()->randomElement([true,false]),
            // "special_offer"=>fake()->randomElement([true,false]),
            // "status"=>fake()->randomElement(["active","inactive"]),
            "status"=>fake()->randomElement(["pending","approved","disapproved"]),
            "created_at"=>fake()->dateTimeBetween("-4 months", now()),
    ];
    }
}
