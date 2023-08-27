<?php

namespace App\Services\BroadcastNotifications;

use App\Models\ProductQuestion;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\User;
use App\Notifications\Blogs\NewBlogCommentFromUserNotification;
use App\Notifications\ProductQuestions\NewProductQuestionFromUserNotification;
use Illuminate\Support\Facades\Notification;

class NewProductQuestionNotificationSendToSellerDashboardService
{
    public function send(ProductQuestion $productQuestion): void
    {
        $seller = User::findOrFail($productQuestion->shop_id);

        $product = Product::findOrFail($productQuestion->product_id);

        $seller->notify(new NewProductQuestionFromUserNotification($productQuestion, $product));

    }
}
