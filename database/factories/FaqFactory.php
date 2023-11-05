<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'faq_sub_category_id' => fake()->numberBetween(1, 18),
            'question' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'answer' => fake()->paragraph(10),
            'created_at' => fake()->dateTimeBetween('-9 months', now()),
        ];
    }
}
