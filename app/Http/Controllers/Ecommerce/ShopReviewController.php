<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopReviewRequest;
use App\Models\ShopReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShopReviewController extends Controller
{
    public function storeReview(ShopReviewRequest $request): RedirectResponse
    {
        ShopReview::create($request->validated());

        return back();
    }

    public function updateReview(ShopReviewRequest $request, int $reviewId): RedirectResponse
    {
        $shopReview=ShopReview::findOrFail($reviewId);

        $shopReview->update(["review_text"=>$request->review_text]);

        return back();
    }

    public function destroyReview(int $reviewId): RedirectResponse
    {
        $shopReview=ShopReview::findOrFail($reviewId);

        $shopReview->delete();

        return back();
    }
}
