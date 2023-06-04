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
            "name"=>"Apparel & Beauty",
            "slug"=>"apparel-and-beauty",
            "image"=>"apparel-and-beauty.jpeg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Foods & Groceries",
            "slug"=>"foods-and-groceries",
            "image"=>"foods-and-groceries.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Sport Accessories",
            "slug"=>"sport-accessories",
            "image"=>"sport-accessories.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Electronic Devices",
            "slug"=>"electronic-devices",
            "image"=>"electronic-devices.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Electronic Accessories",
            "slug"=>"electronic-accessories",
            "image"=>"electronic-accessories.webp",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Home Appliances",
            "slug"=>"home-appliances",
            "image"=>"home-appliances.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Babies & Toys",
            "slug"=>"babies-and-toys",
            "image"=>"babies-and-toys.jpg",
        ]);
        BlogCategory::factory()->create([
            "name"=>"Pet Accessories",
            "slug"=>"pet-accessories",
            "image"=>"pet-accessories.webp",
        ]);
    }
}
