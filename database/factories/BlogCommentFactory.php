<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogComment>
 */
class BlogCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'blog_post_id' => fake()->numberBetween(1, 50),
            'user_id' => fake()->numberBetween(5, 70),
            'comment' => fake()->paragraph(5),
            'created_at' => fake()->dateTimeBetween('-5 months', now()),
        ];
    }
}
