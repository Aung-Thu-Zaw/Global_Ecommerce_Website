<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FaqCategory::create([
            'name' => 'Account Managements',
            'slug' => 'account-managements',
        ]);

        FaqCategory::create([

            'name' => 'Orders',
            'slug' => 'orders',
        ]);

        FaqCategory::create([

            'name' => 'Payments',
            'slug' => 'payments',
        ]);

        FaqCategory::create([

            'name' => 'Shipping And Delivery',
            'slug' => 'shipping-and-delivery',
        ]);

        FaqCategory::create([

            'name' => 'Returns And Refunds',
            'slug' => 'returns-and-refunds',
        ]);

        FaqCategory::create([

            'name' => 'Sell on Global E-commerce',
            'slug' => 'sell-on-global-ecommerce',
        ]);

        FaqCategory::create([

            'name' => 'Shop Categories',
            'slug' => 'shop-categories',
        ]);

        FaqCategory::create([

            'name' => 'Promotions',
            'slug' => 'promotions',
        ]);
    }
}
