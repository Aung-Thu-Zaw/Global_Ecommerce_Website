<?php

namespace App\Services\UploadFiles;

use App\Models\Image;
use App\Models\ProductReview;
use Illuminate\Http\UploadedFile;

class ProductReviewMultiImageUploadService
{
    /**
     * @param  array<UploadedFile>  $images
     */
    public function createMultiImage(array $images, ProductReview $productReview): void
    {
        foreach ($images as $image) {
            $originalName = $image->getClientOriginalName();

            $finalName = 'product-review'.'-'.time().'-'.$originalName;

            $image->storeAs('product-reviews', $finalName);

            Image::create(['product_review_id' => $productReview->id, 'img_path' => $finalName]);
        }
    }
}
