<?php

namespace App\Services;

use App\Models\ProductBanner;
use App\Models\VendorProductBanner;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductBannerImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/product-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $productBannerImage): string
    {
        if(is_string($productBannerImage)) {

            ProductBanner::deleteImage($productBannerImage);
        }

        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/product-banners/"), $finalName);

        return $finalName;
    }

    public function updateImageForVendor(Request $request, VendorProductBanner $vendorProductBanner): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            VendorProductBanner::deleteImage($vendorProductBanner);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $originalName=$file->getClientOriginalName();
            $extension=$file->extension();
            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $file->move(storage_path("app/public/product-banners/"), $finalName);

            return $finalName;
        } else {
            return $vendorProductBanner->image;
        }
    }
}
