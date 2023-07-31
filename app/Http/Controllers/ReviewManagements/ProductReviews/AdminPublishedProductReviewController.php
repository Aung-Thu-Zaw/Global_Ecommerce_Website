<?php

namespace App\Http\Controllers\ReviewManagements\ProductReviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;

class AdminPublishedProductReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $publishedProductReviews=ProductReview::search(request("search"))
                                              ->query(function (Builder $builder) {
                                                  $builder->with(["product:id,name","user:id,name"]);
                                              })
                                              ->where("status", 1)
                                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                                              ->paginate(request("per_page", 10))
                                              ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ProductReviews/PublishedReviews/Index", compact("publishedProductReviews"));
    }

    public function show(Request $request, ProductReview $productReview): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $productReview->load(["product:id,name","user:id,name,email"]);

        return inertia("Admin/ReviewManagements/ProductReviews/PublishedReviews/Details", compact("productReview", "queryStringParams"));
    }

    public function update(Request $request, ProductReview $productReview): RedirectResponse
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $productReview->update(["status"=>false]);

        return to_route('admin.product-reviews.published.index', $queryStringParams)->with("success", "Product review has been successfully unpublished.");
    }
}
