<?php

namespace App\Actions\Admin\UserManagements\AdminManage;

use App\Models\User;
use App\Services\UploadFiles\AdminUserAvatarUploadService;
use Illuminate\Support\Str;

class CreateAdminAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): User
    {
        $avatar = isset($data['avatar']) ? (new AdminUserAvatarUploadService())->createImage($data['avatar']) : null;

        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'about' => $data['about'],
            'address' => $data['address'],
            'gender' => $data['gender'],
            'password' => $data['password'],
            'status' => $data['status'],
            'birthday' => $data['birthday'],
            'role' => $data['role'],
            'avatar' => $avatar,
        ]);

        return $user;
    }
}
