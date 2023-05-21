<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\VendorProductBanner;
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
        $followers=$user->followers;

        $vendorProductBanners=VendorProductBanner::select("user_id", "image", "url")
                                     ->where([["status", "show"],["user_id",$shopId]])
                                     ->orderBy("id", "desc")
                                     ->get();

        $products=Product::select("image", "name", "slug", "price", "discount")
                         ->where([["status", "active"],["user_id",$shopId]])
                         ->inRandomOrder()
                         ->limit(20)
                         ->get();

        return inertia("Ecommerce/Shop/Index", compact("shop", "followings", "followers", "vendorProductBanners", "products"));
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
