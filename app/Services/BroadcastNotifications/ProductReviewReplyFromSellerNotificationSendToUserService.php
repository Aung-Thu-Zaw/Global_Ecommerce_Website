<?php

namespace App\Services\BroadcastNotifications;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Reply;
use App\Models\User;
use App\Notifications\Reviews\ProductReviewReplyFromSellerNotification;

class ProductReviewReplyFromSellerNotificationSendToUserService
{
    public function send(Reply $reply): void
    {
        $productReview = ProductReview::findOrFail($reply->product_review_id);

        $product = Product::findOrFail($productReview->product_id);

        $user = User::findOrFail($productReview->user_id);

        $user->notify(new ProductReviewReplyFromSellerNotification($reply, $product));
    }
}
