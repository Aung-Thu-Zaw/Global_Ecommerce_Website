<?php

namespace App\Actions\Admin\ReviewManagements\ProductReviews;

use App\Models\Image;
use App\Models\ProductReview;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashProductReviewAction
{
    /**
     * @param  Collection<int,ProductReview>  $productReviews
     */
    public function handle(Collection $productReviews): void
    {
        $productReviews->each(function ($productReview) {
            $multiImages = Image::where('product_review_id', $productReview->id)->get();

            $multiImages->each(function ($image) {
                Image::deleteImage($image);
            });

            $productReview->forceDelete();
        });
    }
}
