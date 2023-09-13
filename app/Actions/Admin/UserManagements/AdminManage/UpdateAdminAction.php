<?php

namespace App\Actions\Admin\UserManagements\AdminManage;

use App\Models\User;
use App\Services\UploadFiles\AdminUserAvatarUploadService;

class UpdateAdminAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, User $user): User
    {
        $avatar = isset($data["avatar"]) ? (new AdminUserAvatarUploadService())->updateImage($data["avatar"], $user->avatar) : $user->avatar;

        $user->update([
            "name" => $data["name"],
            "email" =>  $data["email"],
            "phone"=> $data["phone"],
            "about"=> $data["about"],
            "address"=> $data["address"],
            "gender"=> $data["gender"],
            "password" =>$data["password"] ?? $user->password,
            "status"=> $data["status"],
            "birthday"=> $data["birthday"],
            "role"=> $data["role"],
            "avatar"  =>$avatar
        ]);

        return $user;
    }
}
