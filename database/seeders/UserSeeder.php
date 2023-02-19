<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            "name"=>"Admin",
            "email"=>"admin@gmail.com",
            "password"=>"Password!",
            "role"=>"admin",
        ]);

        User::factory()->create([
            "name"=>"Vendor",
            "email"=>"vendor@gmail.com",
            "password"=>"Password!",
            "role"=>"vendor",
        ]);

        User::factory(50)->create();
    }
}
