<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class VendorProductReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $productReviews=ProductReview::search(request("search"))
                                            ->query(function (Builder $builder) {
                                                $builder->with(["product:id,name","user:id,name"]);
                                            })
                                            ->where("status", 1)
                                            ->where("vendor_id", auth()->id())
                                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                                            ->paginate(request("per_page", 10))
                                            ->appends(request()->all());

        return inertia("Vendor/ProductReviews/Index", compact("productReviews"));
    }

    public function show(int $productReviewId): Response|ResponseFactory
    {
        $queryStringParams=[ "page"=>request("page"),"per_page"=>request("per_page"),"sort"=>request("sort"),"direction"=>request("direction")];

        $productReview=ProductReview::findOrFail($productReviewId);

        $productReview->load(["product:id,name","user:id,name,email"]);

        return inertia("Vendor/ProductReviews/Details", compact("productReview", "queryStringParams"));
    }
}
