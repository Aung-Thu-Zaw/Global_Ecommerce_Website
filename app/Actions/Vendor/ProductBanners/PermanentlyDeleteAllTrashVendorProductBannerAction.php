<?php

namespace App\Actions\Vendor\ProductBanners;

use App\Models\VendorProductBanner;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashVendorProductBannerAction
{
    /**
    * @param Collection<int,VendorProductBanner> $vendorProductBanners
    */

    public function handle(Collection $vendorProductBanners): void
    {
        $vendorProductBanners->each(function ($vendorProductBanner) {

            VendorProductBanner::deleteImage($vendorProductBanner->image);

            $vendorProductBanner->forceDelete();

        });
    }
}
