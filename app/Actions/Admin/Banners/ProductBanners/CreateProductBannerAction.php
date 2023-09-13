<?php

namespace App\Actions\Admin\Banners\ProductBanners;

use App\Models\ProductBanner;
use App\Services\UploadFiles\ProductBannerImageUploadService;

class CreateProductBannerAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        $image = isset($data["image"]) ? (new ProductBannerImageUploadService())->createImage($data["image"]) : null;

        ProductBanner::create([
            "url"=>$data["url"],
            "status"=>"hide",
            "image"=>$image
        ]);
    }
}
