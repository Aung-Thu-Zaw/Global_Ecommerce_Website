<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create([
            "name"=>"Fashion & Beauty",
            "slug"=>"fashion-and-beauty",
            "image"=>"fashion-and-beauty.jpeg",
        ]);
        Category::factory()->create([
            "name"=>"Foods & Groceries",
            "slug"=>"foods-and-groceries",
            "image"=>"foods-and-groceries.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Sport Accessories",
            "slug"=>"sport-accessories",
            "image"=>"sport-accessories.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Electronic Devices",
            "slug"=>"electronic-devices",
            "image"=>"electronic-devices.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Electronic Accessories",
            "slug"=>"electronic-accessories",
            "image"=>"electronic-accessories.webp",
        ]);
        Category::factory()->create([
            "name"=>"Home Accessories",
            "slug"=>"home-accessories",
            "image"=>"home-accessories.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Babies & Toys",
            "slug"=>"babies-and-toys",
            "image"=>"babies-and-toys.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Pet Accessories",
            "slug"=>"pet-accessories",
            "image"=>"pet-accessories.webp",
        ]);
    }
}
