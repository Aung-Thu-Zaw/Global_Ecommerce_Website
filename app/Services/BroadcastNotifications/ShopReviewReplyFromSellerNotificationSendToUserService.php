<?php

namespace App\Services\BroadcastNotifications;

use App\Models\BlogComment;
use App\Models\BlogCommentReply;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Reply;
use App\Models\ShopReview;
use App\Models\User;
use App\Notifications\Blogs\BlogCommentReplyFromAuthorNotification;
use App\Notifications\Reviews\ProductReviewReplyFromSellerNotification;
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
