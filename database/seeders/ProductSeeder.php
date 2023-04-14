<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(300)->create(["brand_id"=>null]);
        Product::factory(500)->create(["discount"=>null]);
        Product::factory(200)->create();
    }
}
