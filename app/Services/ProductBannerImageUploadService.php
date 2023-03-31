<?php

namespace App\Services;

use App\Models\ProductBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductBannerImageUploadService
{
    public function createImage(Request $request): string
    {
        $request->validate([
            "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
        ]);

        $file=$request->file("image");

        /** @var \Illuminate\Http\UploadedFile $file */

        $originalName=$file->getClientOriginalName();


        $extension=$file->extension();
        $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

        $file->move(storage_path("app/public/product-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, ProductBanner $productBanner): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            ProductBanner::deleteImage($productBanner);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $originalName=$file->getClientOriginalName();
            $extension=$file->extension();
            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $file->move(storage_path("app/public/product-banners/"), $finalName);

            return $finalName;
        } else {
            return $productBanner->image;
        }
    }
}
