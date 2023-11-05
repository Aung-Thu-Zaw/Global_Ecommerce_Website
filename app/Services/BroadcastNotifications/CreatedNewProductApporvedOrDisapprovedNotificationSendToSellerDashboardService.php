<?php

namespace App\Services\BroadcastNotifications;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Products\AdminApprovedCreatedNewProductNotification;
use App\Notifications\Products\AdminDisapprovedCreatedNewProductNotification;

class CreatedNewProductApporvedOrDisapprovedNotificationSendToSellerDashboardService
{
    public function send(Product $product): void
    {
        $seller = User::findOrFail($product->seller_id);

        $product->status === 'approved' ? $seller->notify(new AdminApprovedCreatedNewProductNotification($product)) :
                                        $seller->notify(new AdminDisapprovedCreatedNewProductNotification($product));
    }
}
