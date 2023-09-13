<?php

namespace App\Services\UploadFiles;

use App\Models\Brand;
use Illuminate\Http\UploadedFile;

class BrandImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/brands/"), $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $brandImage): string
    {
        if(is_string($brandImage)) {

            Brand::deleteImage($brandImage);
        }

        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/brands/"), $finalName);

        return $finalName;
    }
}
