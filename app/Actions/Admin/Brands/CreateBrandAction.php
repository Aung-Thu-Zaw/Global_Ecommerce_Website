<?php

namespace App\Actions\Admin\Brands;

use App\Models\Brand;
use App\Services\UploadFiles\BrandImageUploadService;

class CreateBrandAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        $image = isset($data["image"]) ? (new BrandImageUploadService())->createImage($data["image"]) : null;

        Brand::create([
            "category_id" => $data["category_id"],
            "name" => $data["name"],
            "description" => $data["description"],
            "image" => $image
        ]);
    }
}
