<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCategory::create([
            "category_id"=>1,
            "name"=>"Home Furniture",
            "slug"=>"home-furniture",
            "image"=>"home-furniture.jpg",
            "status"=>"show"
        ]);
        SubCategory::create([
            "category_id"=>1,
            "name"=>"Vehicle Parts And Accessories",
            "slug"=>"vehicle-parts-and-accessories",
            "image"=>"vechicle-parts.jpg",
            "status"=>"show"
        ]);
        SubCategory::create([
            "category_id"=>1,
            "name"=>"Sport Accessories",
            "slug"=>"sport-accessories",
            "image"=>"sports.jpg",
            "status"=>"show"
        ]);
        SubCategory::create([
            "category_id"=>1,
            "name"=>"Beauty Accessories",
            "slug"=>"beauty-accessories",
            "image"=>"beauty-accessories.jpg",
            "status"=>"show"
        ]);
        SubCategory::create([
            "category_id"=>1,
            "name"=>"Electronic Accessories",
            "slug"=>"electronic-accessories",
            "image"=>"electronic-accessories.webp",
            "status"=>"show"
        ]);
        SubCategory::create([
            "category_id"=>1,
            "name"=>"Electronic Devices",
            "slug"=>"electronic-devices",
            "image"=>"electronic-devices.jpg",
            "status"=>"show"
        ]);
        SubCategory::create([
            "category_id"=>1,
            "name"=>"Pet Accessories",
            "slug"=>"pet-accessories",
            "image"=>"pet-accessories.webp",
            "status"=>"show"
        ]);
        SubCategory::create([
            "category_id"=>1,
            "name"=>"Fashion",
            "slug"=>"fashion",
            "image"=>"fashion.jpg",
            "status"=>"show"
        ]);
    }
}
