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

class NewShopReviewNotificationSendToAdminDashboardService
{
    public function send(ShopReview $shopReview): void
    {
        $admins = User::where("role", "admin")->get();

        Notification::send($admins, new NewShopReviewFromCustomerNotification($shopReview));
    }
}
