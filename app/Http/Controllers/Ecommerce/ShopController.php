<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class ShopController extends Controller
{
    public function show(int $shopId): Response|ResponseFactory
    {
        $shop=User::findOrFail($shopId);

        $user=auth()->user();

        $followings=$user->followings;

        return inertia("Ecommerce/Shop/Index", compact("shop", "followings"));
    }

    public function followShop(int $shopId): RedirectResponse
    {
        $user=auth()->user();

        $shop=User::find($shopId);

        $user->follow($shop);

        return back();
    }


    public function unfollowShop(int $shopId): RedirectResponse
    {
        $user=auth()->user();

        $shop=User::find($shopId);

        $user->unfollow($shop);

        return back();
    }
}
