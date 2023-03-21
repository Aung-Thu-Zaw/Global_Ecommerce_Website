<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandImageUploadService
{
    public function uploadImage(Request $request): string
    {
        $request->validate([
            "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
        ]);


        $extension=$request->file("image")->extension();
        $finalName= Str::slug($request->name, '-')."."."$extension";

        $request->file("image")->move(storage_path("app/public/brands/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, $brand): ?string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            Brand::deleteImage($brand);

            $extension=$request->file("image")->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/brands/"), $finalName);

            return $finalName;
        } else {
            return $brand->image;
        }
    }
}
