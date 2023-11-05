<?php

namespace Database\Seeders;

use App\Models\ShopReview;
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
        ShopReview::factory(50)->create(['shop_id' => 3, 'status' => 'published']);
        ShopReview::factory(50)->create(['shop_id' => 3, 'status' => 'unpublished']);
    }
}
