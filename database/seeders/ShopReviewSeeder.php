<?php

namespace Database\Seeders;

use App\Models\ShopReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShopReview::factory(3000)->create();
        ShopReview::factory(100)->create(["seller_id"=>3,"status"=>true]);
    }
}
