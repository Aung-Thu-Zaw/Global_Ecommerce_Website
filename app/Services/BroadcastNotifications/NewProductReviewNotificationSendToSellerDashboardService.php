<?php

namespace App\Services\BroadcastNotifications;

use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Notifications\Blogs\NewBlogCommentFromUserNotification;
use App\Notifications\Reviews\NewProductReviewFromCustomerNotification;
use Illuminate\Support\Facades\Notification;

class NewProductReviewNotificationSendToSellerDashboardService
{
    public function send(ProductReview $productReview): void
    {
        $seller = User::findOrFail($productReview->shop_id);

        $seller->notify(new NewProductReviewFromCustomerNotification($productReview));
    }
}
