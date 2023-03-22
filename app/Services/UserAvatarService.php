<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Laravolt\Avatar\Avatar;

class UserAvatarService
{
    public function regenerateDefaultAvatar(Request $request): void
    {
        if ($request->user()->isDirty('name')) {
            $userId=$request->user()->id;


            if (empty($request->user()->avatar) && file_exists(storage_path("app/public/avatars/default-avatar-$userId.png"))) {
                unlink(storage_path("app/public/avatars/default-avatar-$userId.png"));
            }

            $colors=[
                "#f44336",
                "#E91E63",
                "#9C27B0",
                "#673AB7",
                "#3F51B5",
                "#2196F3",
                "#03A9F4",
                "#00BCD4",
                "#009688",
                "#4CAF50",
                "#8BC34A",
                "#CDDC39",
                "#FFC107",
                "#FF9800",
                "#FF5722",
            ];

            $randomColor=array_rand($colors, 1);

            $avatar=new Avatar();

            $avatar->create($request->name)->setBackground($colors[$randomColor])->setBorder(0, "background")->save(storage_path("app/public/avatars/default-avatar-$userId.png"));
        }
    }

    public function uploadAvatar(Request $request): void
    {
        if ($request->hasFile("avatar")) {
            $user=$request->user();

            User::deleteDefaultAvatar($user);

            User::deleteUserAvatar($user);

            $extension=$request->file("avatar")->extension();

            $finalName="avatar-$user->id.$extension";

            $request->file("avatar")->move(storage_path("app/public/avatars/"), $finalName);

            $request->user()->avatar=$finalName;
        }
    }
}
