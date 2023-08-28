<?php

namespace App\Http\Controllers\Ecommerce\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviewReplyRequest;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductReviewReplyController extends Controller
{
    public function storeProductReviewReply(ProductReviewReplyRequest $request): RedirectResponse
    {
        Reply::create($request->validated());

        return back();
    }
}
