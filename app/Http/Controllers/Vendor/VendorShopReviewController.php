<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\ShopReview;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class VendorShopReviewController extends Controller
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

        return inertia("Vendor/ShopReviews/Index", compact("shopReviews"));
    }

    public function show(int $shopReviewId): Response|ResponseFactory
    {
        $queryStringParams=[ "page"=>request("page"),"per_page"=>request("per_page"),"sort"=>request("sort"),"direction"=>request("direction")];

        $shopReview=ShopReview::with(["user:id,name,email","shop:id,shop_name"])->findOrFail($shopReviewId);

        return inertia("Vendor/ShopReviews/Details", compact("shopReview", "queryStringParams"));
    }
}
