<?php

namespace App\Actions\Vendor\ProductBanners;

use App\Models\VendorProductBanner;
use App\Services\ProductBannerImageUploadService;

class UpdateVendorProductBannerAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, VendorProductBanner $vendorProductBanner): void
    {
        $image = isset($data["image"]) ? (new ProductBannerImageUploadService())->updateImage($data["image"], $vendorProductBanner->image) : $vendorProductBanner->image;

        $vendorProductBanner->update([
            "user_id"=>$data["user_id"],
            "url"=>$data["url"],
            "status"=>$data["status"],
            "image"=>$image
        ]);
    }
}
