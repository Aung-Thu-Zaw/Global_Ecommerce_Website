<?php

namespace App\Services\BroadcastNotifications;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Products\SellerCreateNewProductNotification;
use Illuminate\Support\Facades\Notification;

class SellerCreatesANewProductNotificationSendToAdminDashboardService
{
    public function send(Product $product): void
    {
        $admins = User::where("role", "admin")->get();

        Notification::send($admins, new SellerCreateNewProductNotification($product));
    }
}
