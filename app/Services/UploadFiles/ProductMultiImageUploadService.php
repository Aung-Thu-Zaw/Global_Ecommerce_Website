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

            $originalName=$image->getClientOriginalName();

            $finalName="product"."-".time()."-".$originalName;

            $image->move(storage_path("app/public/products/"), $finalName);

            $image=new Image();
            $image->product_id=$product->id;
            $image->img_path=$finalName;
            $image->save();
        }
    }
}
