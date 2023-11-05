<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code' => 'NEW CLIENT',
            'discount_type' => 'fixed_amount',
            'discount_amount' => 50,
            'min_spend' => 250,
            'start_date' => now(),
            'end_date' => now()->addDays(100),
            'max_uses' => 1000000,
        ]);
        Coupon::create([
            'code' => 'HAPPY SHOPPING',
            'discount_type' => 'fixed_amount',
            'discount_amount' => 100,
            'min_spend' => 1000,
            'start_date' => now(),
            'end_date' => now()->addDays(10),
            'max_uses' => 2000,
        ]);
        Coupon::create([
            'code' => 'CHRISTMAS SHOPPING',
            'discount_type' => 'percentage',
            'discount_amount' => 5,
            'min_spend' => 1200,
            'start_date' => now(),
            'end_date' => now()->addDays(5),
            'max_uses' => 1000,
        ]);
        Coupon::create([
            'code' => 'NEW YEAR SHOPPING',
            'discount_type' => 'percentage',
            'discount_amount' => 10,
            'min_spend' => 3000,
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'max_uses' => 10000,
        ]);
        Coupon::create([
            'code' => 'WEEKEND SHOPPING',
            'discount_type' => 'fixed_amount',
            'discount_amount' => 100,
            'min_spend' => 1000,
            'start_date' => now(),
            'end_date' => now()->addDays(1),
            'max_uses' => 10000,
        ]);
    }
}
