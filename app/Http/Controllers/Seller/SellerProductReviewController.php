<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SellerProductReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $productReviews=ProductReview::search(request("search"))
                                     ->query(function (Builder $builder) {
                                         $builder->with(["product:id,name","user:id,name"]);
                                     })
                                     ->where("status", 1)
                                     ->where("seller_id", auth()->id())
                                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                                     ->paginate(request("per_page", 10))
                                     ->appends(request()->all());

        return inertia("Seller/ProductReviews/Index", compact("productReviews"));
    }

    public function show(Request $request, ProductReview $productReview): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $productReview->load(["product:id,name","user:id,name,email"]);

        return inertia("Seller/ProductReviews/Details", compact("productReview", "queryStringParams"));
    }
}
