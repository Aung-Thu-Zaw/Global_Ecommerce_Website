<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class FollowedShopController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $user=auth()->user();

        $followedShops=$user->followings()->with('followable')->get();

        return inertia("User/FollowedShops/Index", compact("followedShops"));
    }

    public function unfollowShop($shopId): RedirectResponse
    {
        $user=auth()->user();

        $shop=User::find($shopId);

        $user->unfollow($shop);

        return back();
    }
}
