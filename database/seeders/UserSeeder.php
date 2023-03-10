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
            "password"=>bcrypt("Password!"),
            "role"=>"admin",
        ]);

        User::factory()->create([
            "name"=>"Vendor",
            "email"=>"vendor@gmail.com",
            "password"=>bcrypt("Password!"),
            "role"=>"vendor",
        ]);

        User::factory()->create([
            "name"=>"User",
            "email"=>"user@gmail.com",
            "password"=>bcrypt("Password!"),
            "role"=>"user",
        ]);

        User::factory(20)->create(["role"=>"vendor","status"=>"inactive"]);
    }
}
