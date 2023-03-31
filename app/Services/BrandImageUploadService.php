<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandImageUploadService
{
    public function createImage(Request $request): string
    {
        $request->validate([
            "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
        ]);


        $file=$request->file("image");

        /** @var \Illuminate\Http\UploadedFile $file */

        $extension=$file->extension();

        $finalName= Str::slug($request->name, '-')."."."$extension";

        $file->move(storage_path("app/public/brands/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, Brand $brand): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            Brand::deleteImage($brand);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $file->move(storage_path("app/public/brands/"), $finalName);

            return $finalName;
        } else {
            return $brand->image;
        }
    }
}
