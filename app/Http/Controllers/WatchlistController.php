<?php

namespace App\Http\Controllers;

use App\Http\Requests\WatchlistRequest;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class WatchlistController extends Controller
{
    public function index(): Response|ResponseFactory
    {

        $watchlists=auth()->user()->watchlists;
        $shopIds=$watchlists->pluck("shop_id")->unique()->values();
        $shops = User::select("id", "shop_name")->whereIn('id', $shopIds)->get();


        $watchlists->load(["product.shop","product.brand","product.sizes","product.colors"]);

        return inertia("Ecommerce/Watchlist/Index", compact("shops", "watchlists"));
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
