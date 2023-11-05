<?php

namespace App\Services\UploadFiles;

use App\Models\ProductBanner;
use Illuminate\Http\UploadedFile;

class ProductBannerImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName = $image->getClientOriginalName();

        $finalName = time().'-'.$originalName;

        $image->storeAs('product-banners', $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $productBannerImage): string
    {
        if (is_string($productBannerImage)) {
            ProductBanner::deleteImage($productBannerImage);
        }

        $originalName = $image->getClientOriginalName();

        $finalName = time().'-'.$originalName;

        $image->storeAs('product-banners', $finalName);

        return $finalName;
    }
}
