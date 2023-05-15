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

        return inertia("Ecommerce/Shop/Index", compact("shop"));

    }

    public function followShop(int $shopId): RedirectResponse
    {

        $user=auth()->user();

        $shop=User::find($shopId);

        $user->follow($shop);

        return back()->with("success", "follow store");
    }


    public function unfollowShop(int $shopId): RedirectResponse
    {
        $user=auth()->user();

        $shop=User::find($shopId);

        $user->unfollow($shop);

        return back()->with("success", "unfollow store");
    }
}
