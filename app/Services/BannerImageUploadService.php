<?php

namespace App\Services;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerImageUploadService
{
    public function createImage(Request $request): string
    {
        $request->validate([
            "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
        ]);

        $originalName=$request->file("image")->getClientOriginalName();


        $extension=$request->file("image")->extension();
        $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

        $request->file("image")->move(storage_path("app/public/banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, object $banner): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            Banner::deleteImage($banner);

            $originalName=$request->file("image")->getClientOriginalName();
            $extension=$request->file("image")->extension();
            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/banners/"), $finalName);

            return $finalName;
        } else {
            return $banner->image;
        }
    }
}
