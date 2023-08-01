<?php

namespace App\Actions\Admin\UserManagements;

use App\Models\User;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashUserAction
{
    /**
    * @param Collection<int,User> $users
    */

    public function handle(Collection $users): void
    {
        $users->each(function ($user) {

            User::deleteUserAvatar($user->avatar);

            $user->forceDelete();

        });
    }
}
