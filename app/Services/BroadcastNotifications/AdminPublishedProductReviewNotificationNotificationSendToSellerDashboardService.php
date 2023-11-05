<?php

namespace App\Services\BroadcastNotifications;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Notifications\Reviews\AdminPublishedProductReviewNotification;

class AdminPublishedProductReviewNotificationNotificationSendToSellerDashboardService
{
    public function send(ProductReview $productReview): void
    {
        $seller = User::findOrFail($productReview->shop_id);

        $product = Product::findOrFail($productReview->product_id);

        $seller->notify(new AdminPublishedProductReviewNotification($productReview, $product));
    }
}
