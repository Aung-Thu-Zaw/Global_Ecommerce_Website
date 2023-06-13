<?php

namespace App\Actions;

use App\Models\User;
use Laravolt\Avatar\Avatar;

class CreateUserAction
{
    /**
    * @param array<string> $userData
    */
    public function execute(array $userData): User
    {
        unset($userData["captcha_token"]);

        $user = User::create($userData);

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

        $avatar->create($user->name)->setBackground($colors[$randomColor])->setBorder(0, "background")->save(storage_path("app/public/avatars/default-avatar-$user->id.png"));

        return $user;
    }
}
