<?php

namespace App\Actions\Admin\Brands;

use App\Models\Brand;
use App\Services\UploadFiles\BrandImageUploadService;

class UpdateBrandAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, Brand $brand): void
    {
        $image = isset($data["image"]) ? (new BrandImageUploadService())->updateImage($data["image"], $brand->image) : $brand->image;

        $brand->update([
            "category_id" => $data["category_id"],
            "name" => $data["name"],
            "description" => $data["description"],
            "image" => $image
        ]);
    }
}
