<?php

namespace App\Services\BroadcastNotifications;

use App\Models\ProductReview;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\ShopReview;
use App\Models\User;
use App\Notifications\Blogs\NewBlogCommentFromUserNotification;
use App\Notifications\ProductQuestions\NewProductQuestionFromUserNotification;
use App\Notifications\Reviews\AdminPublishedProductReviewNotification;
use App\Notifications\Reviews\AdminPublishedShopReviewNotification;
use Illuminate\Support\Facades\Notification;

class AdminPublishedShopReviewNotificationNotificationSendToSellerDashboardService
{
    public function send(ShopReview $shopReview): void
    {
        $seller = User::findOrFail($shopReview->shop_id);

        $seller->notify(new AdminPublishedShopReviewNotification($shopReview, $seller));
    }
}
