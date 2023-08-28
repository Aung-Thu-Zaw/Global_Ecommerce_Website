<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\FollowedShopNotification;

class UserShopInteractionService
{
    public function follow(int $shopId): void
    {
        $shop = User::findOrFail($shopId);

        $user = User::findOrFail(auth()->id());

        $user->follow($shop);

        $shop->notify(new FollowedShopNotification($user));
    }

    public function unfollow(int $shopId): void
    {
        $shop = User::findOrFail($shopId);

        $user = User::findOrFail(auth()->id());

        $user->unfollow($shop);
    }
}
