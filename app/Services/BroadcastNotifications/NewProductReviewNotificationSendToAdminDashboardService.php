<?php

namespace App\Services\BroadcastNotifications;

use App\Models\ProductReview;
use App\Models\User;
use App\Notifications\Reviews\NewProductReviewFromCustomerNotification;
use Illuminate\Support\Facades\Notification;

class NewProductReviewNotificationSendToAdminDashboardService
{
    public function send(ProductReview $productReview): void
    {
        $admins = User::where('role', 'admin')->get();

        Notification::send($admins, new NewProductReviewFromCustomerNotification($productReview));
    }
}
