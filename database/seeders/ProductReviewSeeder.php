<?php

namespace Database\Seeders;

use App\Models\ProductReview;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductReview::factory(3000)->create();
        ProductReview::factory(50)->create(['shop_id' => 3, 'status' => 'published']);
        ProductReview::factory(50)->create(['shop_id' => 3, 'status' => 'unpublished']);
    }
}
