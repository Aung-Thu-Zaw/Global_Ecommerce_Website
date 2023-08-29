<?php

namespace App\Services;

use App\Models\Image;
use App\Models\ProductReview;
use Illuminate\Http\UploadedFile;

class ProductReviewMultiImageUploadService
{
    /**
     * @param array<UploadedFile> $images
     */
    public function createMultiImage(array $images, ProductReview $productReview): void
    {
        foreach ($images as $image) {

            $originalName = $image->getClientOriginalName();

            $finalName = "product-review"."-".time()."-".$originalName;

            $image->move(storage_path("app/public/product-reviews/"), $finalName);

            $image = new Image();
            $image->product_review_id = $productReview->id;
            $image->img_path = $finalName;
            $image->save();
        }
    }
}
