<?php

namespace App\Actions\Admin\ReviewManagements\ProductReviews;

use App\Models\Image;
use App\Models\ProductReview;
use Illuminate\Support\Collection;

class PermanentlyDeleteTrashProductReviewAction
{
    public function handle(ProductReview $productReview): void
    {
        $multiImages = Image::where("product_review_id", $productReview->id)->get();

        $multiImages->each(function ($image) {
            Image::deleteImage($image);
        });

        $productReview->forceDelete();
    }
}
