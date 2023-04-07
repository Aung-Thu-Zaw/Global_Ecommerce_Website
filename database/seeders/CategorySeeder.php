<?php

namespace Database\Seeders;

use App\Models\Category;
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
            "name"=>"Home Appliances",
            "slug"=>"home-appliances",
            "image"=>"home-appliances.jpg",
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

        Category::factory(5)->create(["parent_id"=>1]);
        Category::factory(3)->create(["parent_id"=>2]);
        Category::factory(7)->create(["parent_id"=>3]);
        Category::factory(8)->create(["parent_id"=>4]);
        Category::factory(10)->create(["parent_id"=>5]);
        Category::factory(3)->create(["parent_id"=>6]);
        Category::factory(6)->create(["parent_id"=>7]);
        Category::factory(2)->create(["parent_id"=>8]);




        Category::factory(3)->create(["parent_id"=>12]);
        Category::factory(3)->create(["parent_id"=>14]);
        Category::factory(3)->create(["parent_id"=>15]);
        Category::factory(3)->create(["parent_id"=>14]);
        Category::factory(3)->create(["parent_id"=>19]);
        Category::factory(3)->create(["parent_id"=>26]);
        Category::factory(3)->create(["parent_id"=>20]);
        Category::factory(3)->create(["parent_id"=>18]);
    }
}
