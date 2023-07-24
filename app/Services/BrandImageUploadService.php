<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\UploadedFile;

class BrandImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName=$image->getClientOriginalName();

        $image->move(storage_path("app/public/brands/"), $originalName);

        return $originalName;
    }

    public function updateImage(UploadedFile|string $image, string $brandImage): string
    {
        if($image && is_string($image)) {

            return $image;

        } elseif($image && is_uploaded_file($image)) {

            Brand::deleteImage($brandImage);

            $originalName=$image->getClientOriginalName();

            $image->move(storage_path("app/public/brands/"), $originalName);

            return $originalName;

        }

        return "";
    }
}
