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
            "deleted_at"=>null
        ]);

        User::factory()->create([
            "name"=>"Vendor",
            "email"=>"vendor@gmail.com",
            "password"=>"Password!",
            "role"=>"vendor",
            "deleted_at"=>null
        ]);

        User::factory()->create([
            "name"=>"User",
            "email"=>"user@gmail.com",
            "password"=>"Password!",
            "role"=>"user",
            "deleted_at"=>null
        ]);

        User::factory(30)->create();
        User::factory(30)->create(["deleted_at"=>null]);
    }
}
