<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ShopReview;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SellerShopReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $shopReviews=ShopReview::search(request("search"))
                               ->query(function (Builder $builder) {
                                   $builder->with(["user:id,name","shop:id,shop_name"]);
                               })
                               ->where("status", 1)
                               ->where("vendor_id", auth()->id())
                               ->orderBy(request("sort", "id"), request("direction", "desc"))
                               ->paginate(request("per_page", 10))
                               ->appends(request()->all());

        return inertia("Seller/ShopReviews/Index", compact("shopReviews"));
    }

    public function show(Request $request, ShopReview $shopReview): Response|ResponseFactory
    {
        $shopReview->load(["shop:id,shop_name","user:id,name,email"]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Seller/ShopReviews/Details", compact("shopReview", "queryStringParams"));
    }
}
