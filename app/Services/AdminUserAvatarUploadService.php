<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminUserAvatarUploadService
{
    public function createImage(Request $request): ?string
    {
        if ($request->hasFile("avatar")) {
            $request->validate([
                "avatar"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);


            $file=$request->file("avatar");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $file->move(storage_path("app/public/avatars/"), $finalName);

            return $finalName;
        } else {
            return null;
        }
    }

    public function updateImage(Request $request, User $user): string
    {
        if ($request->hasFile("avatar")) {
            $request->validate([
                "avatar"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            User::deleteUserAvatar($user);

            $file=$request->file("avatar");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $file->move(storage_path("app/public/avatars/"), $finalName);

            return $finalName;
        } else {
            return $user->avatar;
        }
    }
}
