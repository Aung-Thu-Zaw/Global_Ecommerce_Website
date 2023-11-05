<?php

namespace App\Actions\Ecommerce\Reviews;

use App\Models\ShopReview;

class CreateShopReviewAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): ShopReview
    {
        $shopReview = ShopReview::create([
            'shop_id' => $data['shop_id'],
            'user_id' => $data['user_id'],
            'review_text' => $data['review_text'],
            'status' => $data['status'],
            'rating' => $data['rating'],
        ]);

        return $shopReview;
    }
}
