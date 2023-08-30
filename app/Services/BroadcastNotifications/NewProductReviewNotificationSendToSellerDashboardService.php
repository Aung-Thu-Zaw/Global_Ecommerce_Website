<?php

namespace App\Services\BroadcastNotifications;

use App\Models\ProductReview;
use App\Models\User;
use App\Notifications\Reviews\NewProductReviewFromCustomerNotification;

class NewProductReviewNotificationSendToSellerDashboardService
{
    public function send(ProductReview $productReview): void
    {
        $seller = User::findOrFail($productReview->shop_id);

        $seller->notify(new NewProductReviewFromCustomerNotification($productReview));
    }
}
