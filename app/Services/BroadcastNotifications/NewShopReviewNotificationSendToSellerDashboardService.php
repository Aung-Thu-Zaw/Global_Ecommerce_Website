<?php

namespace App\Services\BroadcastNotifications;

use App\Models\ShopReview;
use App\Models\User;
use App\Notifications\Reviews\NewShopReviewFromCustomerNotification;

class NewShopReviewNotificationSendToSellerDashboardService
{
    public function send(ShopReview $shopReview): void
    {
        $seller = User::findOrFail($shopReview->shop_id);

        $seller->notify(new NewShopReviewFromCustomerNotification($shopReview));
    }
}
