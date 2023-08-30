<?php

namespace App\Services\BroadcastNotifications;

use App\Models\Product;
use App\Models\ProductAnswer;
use App\Models\ProductQuestion;
use App\Models\User;
use App\Notifications\ProductQuestions\ProductQuestionAnswerFromSellerNotification;

class ProductQuestionAnswerFromSellerNotificationSendToUserService
{
    public function send(ProductAnswer $productAnswer): void
    {
        $productQuestion = ProductQuestion::findOrFail($productAnswer->product_question_id);

        $product = Product::findOrFail($productQuestion->product_id);

        $user = User::findOrFail($productQuestion->user_id);

        $user->notify(new ProductQuestionAnswerFromSellerNotification($product, $productAnswer));
    }
}
