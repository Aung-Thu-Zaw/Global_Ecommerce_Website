<?php

namespace App\Actions\Admin\ReviewManagements\ProductReviews;

use App\Models\ProductReview;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashProductReviewAction
{
    /**
    * @param Collection<int,ProductReview> $productReviews
    */

    public function handle(Collection $productReviews): void
    {
        $productReviews->each(function ($productReview) {

            $productReview->forceDelete();

        });
    }
}
