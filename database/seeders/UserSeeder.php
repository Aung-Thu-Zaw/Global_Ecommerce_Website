<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin=User::factory()->create([
             "name"=>"Super Admin",
             "email"=>"superadmin@gmail.com",
             "password"=>"Password!",
             "role"=>"admin",
             "deleted_at"=>null
         ]);

        $superAdmin->assignRole(1);

        $role=Role::with("permissions")->where("id", 1)->first();

        $superAdmin->syncPermissions($role->permissions);


        User::factory()->create([
            "name"=>"User",
            "email"=>"user@gmail.com",
            "password"=>"Password!",
            "role"=>"user",
            "deleted_at"=>null
        ]);


        User::factory()->create([
            "name"=>"Seller",
            "email"=>"seller@gmail.com",
            "password"=>"Password!",
            "role"=>"seller",
            "deleted_at"=>null
        ]);

        // Offical Seller
        User::factory(20)->create([
            "role"=>"seller",
            "status"=>"active",
            "offical"=>true,
        ]);

        User::factory(20)->create([
            "role"=>"seller",
            "status"=>"active",
        ]);


        User::factory(20)->create([
            "role"=>"seller",
            "status"=>"inactive",
        ]);

        User::factory(50)->create(["shop_name"=>null,"company_name"=>null,"role"=>"user"]);

    }
}
