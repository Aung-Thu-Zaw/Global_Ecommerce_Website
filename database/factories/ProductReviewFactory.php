<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReview>
 */
class ProductReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "product_id"=>fake()->numberBetween(1, 200),
            "shop_id"=>fake()->numberBetween(3, 40),
            "user_id"=>fake()->numberBetween(5, 113),
            "review_text"=>fake()->paragraph(),
            "rating"=>fake()->numberBetween(1, 5),
            "status"=>fake()->randomElement(["pending","published","unpublished"]),
            "created_at"=>fake()->dateTimeBetween("-5 months", now()),
        ];
    }
}
