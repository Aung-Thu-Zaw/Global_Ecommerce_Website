<?php

namespace App\Actions\Ecommerce\Reviews;

use App\Models\ProductReview;
use App\Models\Reply;
use App\Services\ProductReviewMultiImageUploadService;

class CreateShopReviewReplyAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): Reply
    {
        $reply = Reply::create([
            "shop_review_id" => $data["shop_review_id"],
            "seller_id" => $data["seller_id"],
            "reply_text" => $data["reply_text"],
        ]);

        return $reply;
    }
}
