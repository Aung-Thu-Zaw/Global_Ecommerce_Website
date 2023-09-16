<?php

namespace App\Services\UploadFiles;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\UploadedFile;

class ProductMultiImageUploadService
{
    /**
     * @param array<UploadedFile> $images
     */
    public function createMultiImage(array $images, Product $product): void
    {

        foreach ($images as $image) {

            $originalName = $image->getClientOriginalName();

            $finalName = "product"."-".time()."-".$originalName;

            $image->storeAs("products", $finalName);

            Image::create(["product_id" => $product->id,"img_path" => $finalName]);

        }

    }
}
