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

    public function show(int $id): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $publishedProductReview=ProductReview::findOrFail($id);

        $publishedProductReview->load(["product:id,name","user:id,name,email"]);

        return inertia("Admin/ReviewManagements/ProductReviews/PublishedReviews/Details", compact("publishedProductReview", "paginate"));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pendingProductReview=ProductReview::findOrFail($id);

        $pendingProductReview->update(["status"=>false]);

        return to_route('admin.product-reviews.published.index', "page=$request->page&per_page=$request->per_page")->with("success", "Product review has been successfully suspended.");
    }

}
