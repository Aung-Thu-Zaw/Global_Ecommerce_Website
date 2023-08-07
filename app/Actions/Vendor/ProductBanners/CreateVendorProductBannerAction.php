<?php

namespace App\Actions\Vendor\ProductBanners;

use App\Models\ProductBanner;
use App\Services\ProductBannerImageUploadService;

class CreateVendorProductBannerAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        $image = isset($data["image"]) ? (new ProductBannerImageUploadService())->createImage($data["image"]) : null;

        ProductBanner::create([
            "user_id"=>$data["user_id"],
            "url"=>$data["url"],
            "status"=>"hide",
            "image"=>$image
        ]);
    }
}
