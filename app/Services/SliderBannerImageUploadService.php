<?php

namespace App\Services;

use App\Models\SliderBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SliderBannerImageUploadService
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

        $file->move(storage_path("app/public/slider-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, SliderBanner $sliderBanner): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            SliderBanner::deleteImage($sliderBanner);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $originalName=$file->getClientOriginalName();
            $extension=$file->extension();
            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $file->move(storage_path("app/public/slider-banners/"), $finalName);

            return $finalName;
        } else {
            return $sliderBanner->image;
        }
    }
}
