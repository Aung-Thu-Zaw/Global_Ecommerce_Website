<?php

namespace App\Actions\Ecommerce\Reviews;

use App\Models\ProductReview;
use App\Services\UploadFiles\ProductReviewMultiImageUploadService;

class CreateProductReviewAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): ProductReview
    {
        $productReview = ProductReview::create([
            'product_id' => $data['product_id'],
            'shop_id' => $data['shop_id'],
            'user_id' => $data['user_id'],
            'review_text' => $data['review_text'],
            'status' => $data['status'],
            'rating' => $data['rating'],
        ]);

        if (isset($data['multi_image'])) {
            (new ProductReviewMultiImageUploadService())->createMultiImage($data['multi_image'], $productReview);
        }

        return $productReview;
    }
}
