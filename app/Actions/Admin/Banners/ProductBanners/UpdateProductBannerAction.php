<?php

namespace App\Actions\Admin\Banners\ProductBanners;

use App\Models\ProductBanner;
use App\Services\UploadFiles\ProductBannerImageUploadService;

class UpdateProductBannerAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, ProductBanner $productBanner): void
    {
        $image = isset($data["image"]) ? (new ProductBannerImageUploadService())->updateImage($data["image"], $productBanner->image) : $productBanner->image;

        $productBanner->update([
            "url" => $data["url"],
            "status" => $data["status"],
            "image" => $image
        ]);
    }
}
