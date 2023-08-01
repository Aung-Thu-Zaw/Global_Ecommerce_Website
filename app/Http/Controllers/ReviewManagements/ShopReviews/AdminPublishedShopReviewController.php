<?php

namespace App\Http\Controllers\ReviewManagements\ShopReviews;

use App\Http\Controllers\Controller;
use App\Models\ShopReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminPublishedShopReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $publishedShopReviews=ShopReview::search(request("search"))
                                        ->query(function (Builder $builder) {
                                            $builder->with(["shop:id,shop_name","user:id,name"]);
                                        })
                                        ->where("status", 1)
                                        ->orderBy(request("sort", "id"), request("direction", "desc"))
                                        ->paginate(request("per_page", 10))
                                        ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ShopReviews/PublishedReviews/Index", compact("publishedShopReviews"));
    }

    public function show(Request $request, ShopReview $shopReview): Response|ResponseFactory
    {
        $shopReview->load(["shop:id,shop_name","user:id,name,email"]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/ReviewManagements/ShopReviews/PublishedReviews/Details", compact("shopReview", "queryStringParams"));
    }

    public function update(Request $request, ShopReview $shopReview): RedirectResponse
    {
        $shopReview->update(["status"=>false]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.published.index', $queryStringParams)->with("success", "Shop review has been successfully unpublished.");
    }
}
