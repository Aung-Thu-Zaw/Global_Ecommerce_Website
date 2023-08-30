<?php

namespace App\Http\Controllers\Ecommerce\Reviews;

use App\Actions\Ecommerce\Reviews\CreateShopReviewReplyAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopReviewReplyRequest;
use App\Models\Reply;
use App\Services\BroadcastNotifications\ShopReviewReplyFromSellerNotificationSendToUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShopReviewReplyController extends Controller
{
    public function store(ShopReviewReplyRequest $request): RedirectResponse
    {
        $reply = (new CreateShopReviewReplyAction())->handle($request->validated());

        (new ShopReviewReplyFromSellerNotificationSendToUserService())->send($reply);

        return back();

    }
}
