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
        Category::create([
            "name"=>"Home Furniture",
            "slug"=>"home-furniture",
            "image"=>"home-furniture.jpg",
            "status"=>"show"
        ]);
        Category::create([
            "name"=>"Vehicle Parts And Accessories",
            "slug"=>"vehicle-parts-and-accessories",
            "image"=>"vechicle-parts.jpg",
            "status"=>"show"
        ]);
        Category::create([
            "name"=>"Sport Accessories",
            "slug"=>"sport-accessories",
            "image"=>"sports.jpg",
            "status"=>"show"
        ]);
        Category::create([
            "name"=>"Beauty Accessories",
            "slug"=>"beauty-accessories",
            "image"=>"beauty-accessories.jpg",
            "status"=>"show"
        ]);
        Category::create([
            "name"=>"Electronic Accessories",
            "slug"=>"electronic-accessories",
            "image"=>"electronic-accessories.webp",
            "status"=>"show"
        ]);
        Category::create([
            "name"=>"Electronic Devices",
            "slug"=>"electronic-devices",
            "image"=>"electronic-devices.jpg",
            "status"=>"show"
        ]);
        Category::create([
            "name"=>"Pet Accessories",
            "slug"=>"pet-accessories",
            "image"=>"pet-accessories.webp",
            "status"=>"show"
        ]);
        Category::create([
            "name"=>"Fashion",
            "slug"=>"fashion",
            "image"=>"fashion.jpg",
            "status"=>"show"
        ]);
    }
}




