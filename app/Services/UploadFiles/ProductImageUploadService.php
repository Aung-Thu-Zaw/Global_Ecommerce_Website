<?php

namespace App\Services\UploadFiles;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

class ProductImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/products/"), $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $productImage): string
    {
        if(is_string($productImage)) {

            Product::deleteImage($productImage);
        }

        $originalName=$image->getClientOriginalName();

        $finalName="product"."-".time()."-".$originalName;

        $image->move(storage_path("app/public/products/"), $finalName);

        return $finalName;
    }
}
