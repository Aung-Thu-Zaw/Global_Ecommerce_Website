<?php

namespace App\Services\BroadcastNotifications;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Products\VendorCreateNewProductNotification;
use Illuminate\Support\Facades\Notification;

class VendorCreatesANewProductNotificationSendToAdminDashboardService
{
    public function send(Product $product): void
    {
        $admins=User::where("role", "admin")->get();

        $vendor=User::findOrFail($product->user_id);

        Notification::send($admins, new VendorCreateNewProductNotification($vendor, $product));
    }
}
