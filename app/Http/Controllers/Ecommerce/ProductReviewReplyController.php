<?php

namespace App\Http\Controllers\Ecommerce;

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

    // public function updateProductReviewReply(ProductReviewReplyRequest $request, int $replyId): RedirectResponse
    // {

    //     $productReviewReply=Reply::findOrFail($replyId);

    //     $productReviewReply->update(["reply_text"=>$request->reply_text]);

    //     return back();
    // }

    // public function destroyProductReviewReply(int $replyId): RedirectResponse
    // {
    //     $productReviewReply=Reply::findOrFail($replyId);

    //     $productReviewReply->delete();

    //     return back();
    // }

}
