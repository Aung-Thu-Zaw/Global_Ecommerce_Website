<?php

namespace App\Services\BroadcastNotifications;

use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\ShopReview;
use App\Models\User;
use App\Notifications\Blogs\NewBlogCommentFromUserNotification;
use App\Notifications\Reviews\NewShopReviewFromCustomerNotification;
use Illuminate\Support\Facades\Notification;

class NewShopReviewNotificationSendToSellerDashboardService
{
    public function send(ShopReview $shopReview): void
    {
        $seller = User::findOrFail($shopReview->shop_id);

        $seller->notify(new NewShopReviewFromCustomerNotification($shopReview));
    }
}
