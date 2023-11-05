<?php

namespace App\Services\BroadcastNotifications;

use App\Models\Product;
use App\Models\ProductQuestion;
use App\Models\User;
use App\Notifications\ProductQuestions\NewProductQuestionFromUserNotification;

class NewProductQuestionNotificationSendToSellerDashboardService
{
    public function send(ProductQuestion $productQuestion): void
    {
        $seller = User::findOrFail($productQuestion->seller_id);

        $product = Product::findOrFail($productQuestion->product_id);

        $seller->notify(new NewProductQuestionFromUserNotification($productQuestion, $product));
    }
}
