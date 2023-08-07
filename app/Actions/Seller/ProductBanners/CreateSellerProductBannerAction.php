<?php

namespace App\Actions\Seller\ProductBanners;

use App\Models\SellerProductBanner;
use App\Services\ProductBannerImageUploadService;

class CreateSellerProductBannerAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        $image = isset($data["image"]) ? (new ProductBannerImageUploadService())->createImage($data["image"]) : null;

        SellerProductBanner::create([
            "seller_id"=>$data["seller_id"],
            "url"=>$data["url"],
            "status"=>"hide",
            "image"=>$image
        ]);
    }
}
