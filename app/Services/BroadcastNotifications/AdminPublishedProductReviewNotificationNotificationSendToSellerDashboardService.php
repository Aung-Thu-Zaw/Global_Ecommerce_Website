<?php

namespace App\Services\BroadcastNotifications;

use App\Models\ProductReview;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\User;
use App\Notifications\Blogs\NewBlogCommentFromUserNotification;
use App\Notifications\ProductQuestions\NewProductQuestionFromUserNotification;
use App\Notifications\Reviews\AdminPublishedProductReviewNotification;
use Illuminate\Support\Facades\Notification;

class AdminPublishedProductReviewNotificationNotificationSendToSellerDashboardService
{
    public function send(ProductReview $productReview): void
    {
        $seller = User::findOrFail($productReview->shop_id);

        $product = Product::findOrFail($productReview->product_id);

        $seller->notify(new AdminPublishedProductReviewNotification($productReview, $product));
    }
}
