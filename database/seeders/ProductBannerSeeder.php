<?php

namespace Database\Seeders;

use App\Models\ProductBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductBanner::factory(10)->create();
        ProductBanner::factory(3)->create(["status"=>"show"]);
    }
}
