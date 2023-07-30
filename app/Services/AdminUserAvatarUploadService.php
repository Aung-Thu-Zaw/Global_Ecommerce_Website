<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

class AdminUserAvatarUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/avatars/"), $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $avatar): string
    {
        if(is_string($avatar)) {

            User::deleteUserAvatar($avatar);

        }

        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/avatars/"), $finalName);

        return $finalName;
    }
}
