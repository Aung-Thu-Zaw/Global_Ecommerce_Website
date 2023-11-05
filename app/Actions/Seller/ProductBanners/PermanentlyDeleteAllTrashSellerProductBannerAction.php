<?php

namespace App\Actions\Seller\ProductBanners;

use App\Models\SellerProductBanner;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashSellerProductBannerAction
{
    /**
     * @param  Collection<int,SellerProductBanner>  $sellerProductBanners
     */
    public function handle(Collection $sellerProductBanners): void
    {
        $sellerProductBanners->each(function ($sellerProductBanner) {
            SellerProductBanner::deleteImage($sellerProductBanner->image);

            $sellerProductBanner->forceDelete();
        });
    }
}
