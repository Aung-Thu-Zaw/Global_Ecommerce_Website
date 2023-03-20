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
            "name"=>"Home Furniture",
            "slug"=>"home-furniture",
            "image"=>"home-furniture.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Vehicle Parts And Accessories",
            "slug"=>"vehicle-parts-and-accessories",
            "image"=>"vechicle-parts.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Sport Accessories",
            "slug"=>"sport-accessories",
            "image"=>"sports.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Beauty Accessories",
            "slug"=>"beauty-accessories",
            "image"=>"beauty-accessories.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Electronic Accessories",
            "slug"=>"electronic-accessories",
            "image"=>"electronic-accessories.webp",
        ]);
        Category::factory()->create([
            "name"=>"Electronic Devices",
            "slug"=>"electronic-devices",
            "image"=>"electronic-devices.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Pet Accessories",
            "slug"=>"pet-accessories",
            "image"=>"pet-accessories.webp",
        ]);
        Category::factory()->create([
            "name"=>"Fashion",
            "slug"=>"fashion",
            "image"=>"fashion.jpg",
        ]);

        // Category::factory(30)->create();
        // Category::factory(30)->create(["deleted_at"=>null]);
    }
}
