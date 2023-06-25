<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogCategory::factory()->create([
            "name"=>"Fashion",
            "slug"=>"fashion",
            "image"=>"fashion.webp",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Foods",
            "slug"=>"foods",
            "image"=>"food.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Lifestyle",
            "slug"=>"lifestyle",
            "image"=>"lifestyle.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Sports",
            "slug"=>"sports",
            "image"=>"sports.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Technology",
            "slug"=>"technology",
            "image"=>"technology.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Travel",
            "slug"=>"travel",
            "image"=>"travel.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Beauty & Health",
            "slug"=>"beauty-and-health",
            "image"=>"beauty-and-health.webp",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Home Improvement",
            "slug"=>"home-improvement",
            "image"=>"home-improvement.jpg",
        ]);
    }
}
