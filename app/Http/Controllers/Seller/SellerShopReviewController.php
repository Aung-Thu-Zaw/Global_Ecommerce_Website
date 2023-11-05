<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\ShopReview;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class SellerShopReviewController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $shopReviews = ShopReview::search(request('search'))
                                 ->query(function (Builder $builder) {
                                     $builder->with(['user:id,name', 'shop:id,shop_name']);
                                 })
                                 ->where('shop_id', auth()->id())
                                 ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                 ->paginate(request('per_page', 10))
                                 ->appends(request()->all());

        return inertia('Seller/ShopReviews/Index', compact('shopReviews'));
    }

    public function show(Request $request, ShopReview $shopReview): Response|ResponseFactory
    {
        $shopReview->load(['shop:id,shop_name', 'user:id,name,email']);

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Seller/ShopReviews/Detail', compact('shopReview', 'queryStringParams'));
    }
}
