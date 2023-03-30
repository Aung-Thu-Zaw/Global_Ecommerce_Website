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

        $originalName=$request->file("image")->getClientOriginalName();


        $extension=$request->file("image")->extension();
        $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

        $request->file("image")->move(storage_path("app/public/product-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, object $productBanner): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            ProductBanner::deleteImage($productBanner);

            $originalName=$request->file("image")->getClientOriginalName();
            $extension=$request->file("image")->extension();
            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/product-banners/"), $finalName);

            return $finalName;
        } else {
            return $productBanner->image;
        }
    }
}
