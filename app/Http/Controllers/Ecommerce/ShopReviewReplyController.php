<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopReviewReplyRequest;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShopReviewReplyController extends Controller
{
    public function storeShopReviewReply(ShopReviewReplyRequest $request): RedirectResponse
    {
        Reply::create($request->validated());

        return back();
    }

    public function updateShopReviewReply(ShopReviewReplyRequest $request, int $replyId): RedirectResponse
    {

        $shopReviewReply=Reply::findOrFail($replyId);

        $shopReviewReply->update(["reply_text"=>$request->reply_text]);

        return back();
    }

    public function destroyShopReviewReply(int $replyId): RedirectResponse
    {
        $shopReviewReply=Reply::findOrFail($replyId);

        $shopReviewReply->delete();

        return back();
    }
}
