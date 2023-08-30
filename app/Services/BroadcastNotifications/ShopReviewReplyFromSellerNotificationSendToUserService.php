<?php

namespace App\Services\BroadcastNotifications;

use App\Models\Reply;
use App\Models\ShopReview;
use App\Models\User;
use App\Notifications\Reviews\ShopReviewReplyFromSellerNotification;

class ShopReviewReplyFromSellerNotificationSendToUserService
{
    public function send(Reply $reply): void
    {
        $shopReview = ShopReview::findOrFail($reply->shop_review_id);

        $user = User::findOrFail($shopReview->user_id);

        $seller = User::findOrFail($shopReview->shop_id);

        $user->notify(new ShopReviewReplyFromSellerNotification($reply, $seller));
    }
}
