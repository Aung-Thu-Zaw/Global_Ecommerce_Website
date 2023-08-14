<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "blog_category_id"=>fake()->numberBetween(1, 8),
            "author_id"=>1,
            "title"=>fake()->unique()->sentence(),
            "slug"=>fake()->unique()->slug(),
            "description"=>fake()->paragraph(10),
            "image"=>fake()->imageUrl(),
            "created_at"=>fake()->dateTimeBetween("-4 months", now()),
        ];
    }
}
