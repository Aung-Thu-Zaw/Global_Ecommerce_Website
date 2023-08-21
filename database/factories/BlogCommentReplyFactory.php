<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogCommentReply>
 */
class BlogCommentReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "blog_comment_id" => fake()->numberBetween(1, 100),
            "author_id" => 1,
            "reply_text" => fake()->paragraph()
        ];
    }
}
