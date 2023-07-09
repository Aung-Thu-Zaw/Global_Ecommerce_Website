<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviewRequest;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;

class ProductReviewController extends Controller
{
    public function storeReview(ProductReviewRequest $request): RedirectResponse
    {
        ProductReview::create($request->validated());

        return back();
    }

    public function updateReview(ProductReviewRequest $request, int $reviewId): RedirectResponse
    {
        $productReview=ProductReview::findOrFail($reviewId);

        $productReview->update(["review_text"=>$request->review_text]);

        return back();
    }

    public function destroyReview(int $reviewId): RedirectResponse
    {
        $productReview=ProductReview::findOrFail($reviewId);

        $productReview->delete();

        return back();
    }
}
