<?php

namespace Database\Seeders;

use App\Models\FlashSale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlashSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FlashSale::create([
            "end_date" => null
        ]);
    }
}
