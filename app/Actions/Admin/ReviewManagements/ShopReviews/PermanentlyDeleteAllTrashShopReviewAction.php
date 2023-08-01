<?php

namespace App\Actions\Admin\ReviewManagements\ShopReviews;

use App\Models\ShopReview;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashShopReviewAction
{
    /**
    * @param Collection<int,ShopReview> $shopReviews
    */

    public function handle(Collection $shopReviews): void
    {
        $shopReviews->each(function ($shopReview) {

            $shopReview->forceDelete();

        });
    }
}
