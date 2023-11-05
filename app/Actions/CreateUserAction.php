<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

class CreateUserAction
{
    /**
     * @param  array<string>  $userData
     */
    public function execute(array $userData): User
    {
        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $userData['name'],
            'company_name' => $userData['company_name'] ?? null,
            'shop_name' => $userData['shop_name'] ?? null,
            'email' => $userData['email'],
            'phone' => $userData['phone'] ?? null,
            'password' => $userData['password'],
            'gender' => $userData['gender'],
            'birthday' => $userData['birthday'] ?? null,
            'role' => $userData['role'],
            'status' => $userData['status'],
            'offical' => false,
        ]);

        $colors = [
            '#f44336',
            '#E91E63',
            '#9C27B0',
            '#673AB7',
            '#3F51B5',
            '#2196F3',
            '#03A9F4',
            '#00BCD4',
            '#009688',
            '#4CAF50',
            '#8BC34A',
            '#CDDC39',
            '#FFC107',
            '#FF9800',
            '#FF5722',
        ];

        $randomColor = array_rand($colors, 1);

        $avatar = new Avatar();

        $avatar->create($user['name'])->setBackground($colors[$randomColor])->setBorder(0, 'background')->save(storage_path("app/public/avatars/default-avatar-$user->id.png"));

        return $user;
    }
}
