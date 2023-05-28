<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\WatchlistRequest;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProductInteraction;
use App\Models\Watchlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\ResponseFactory;

class WatchlistController extends Controller
{
    public function index(): Response|ResponseFactory
    {

        $watchlists=auth()->user()->watchlists;
        $shopIds=$watchlists->pluck("shop_id")->unique()->values();
        $shops = User::select("id", "shop_name")->whereIn('id', $shopIds)->get();

        $watchlists->load(["product.shop:id,shop_name","product.brand:id,name","product.sizes","product.colors"]);

        $mostViewedProducts=UserProductInteraction::where('user_id', auth()->user()->id)
                                                  ->groupBy('product_id')
                                                  ->pluck('product_id')
                                                  ->toArray();

        $recommendedProducts = Product::select("id", "image", "name", "slug", "price", "discount")
                                      ->with("productReviews:id,product_id,rating")
                                      ->where("status", "active")
                                      ->whereIn('id', $mostViewedProducts)
                                      ->inRandomOrder()
                                      ->limit(10)
                                      ->get();


        return inertia("User/MyWatchlist/Index", compact("shops", "watchlists", "recommendedProducts"));
    }

    public function store(WatchlistRequest $request): RedirectResponse
    {

        $watchlist=Watchlist::where([["user_id",$request->user_id],["product_id",$request->product_id],["shop_id",$request->shop_id]])->first();

        if(!$watchlist) {
            Watchlist::create($request->validated());
            return back()->with("success", "Item is moved to watchlist, you can re-add it to cart from watchlist.");
        }

        $watchlist->delete();

        return back()->with("info", "Item has been removed from your watchlist");
    }

    public function destroy(Watchlist $watchlist): RedirectResponse
    {
        $watchlist->delete();

        return back()->with("success", "Item has been removed from your watchlist");
    }
}
