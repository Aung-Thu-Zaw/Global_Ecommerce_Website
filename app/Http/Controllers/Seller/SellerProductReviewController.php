<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Traits\HandlesQueryStringParameters;

class SellerProductReviewController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $productReviews = ProductReview::search(request("search"))
                                       ->query(function (Builder $builder) {
                                           $builder->with(["product:id,name","user:id,name"]);
                                       })
                                       ->where("shop_id", auth()->id())
                                       ->orderBy(request("sort", "id"), request("direction", "desc"))
                                       ->paginate(request("per_page", 10))
                                       ->appends(request()->all());

        return inertia("Seller/ProductReviews/Index", compact("productReviews"));
    }

    public function show(Request $request, ProductReview $productReview): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        $productReview->load(["product:id,name","user:id,name,email"]);

        return inertia("Seller/ProductReviews/Detail", compact("productReview", "queryStringParams"));
    }
}
