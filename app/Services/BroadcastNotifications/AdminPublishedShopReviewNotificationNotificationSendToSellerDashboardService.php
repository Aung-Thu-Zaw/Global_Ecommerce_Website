<?php

namespace App\Services\BroadcastNotifications;

use App\Models\ShopReview;
use App\Models\User;
use App\Notifications\Reviews\AdminPublishedShopReviewNotification;

class AdminPublishedShopReviewNotificationNotificationSendToSellerDashboardService
{
    public function send(ShopReview $shopReview): void
    {
        $seller = User::findOrFail($shopReview->shop_id);

        $seller->notify(new AdminPublishedShopReviewNotification($shopReview, $seller));
    }
}
