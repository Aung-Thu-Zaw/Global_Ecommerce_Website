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

        $originalName=$request->file("image")->getClientOriginalName();


        $extension=$request->file("image")->extension();
        $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

        $request->file("image")->move(storage_path("app/public/slider-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, object $sliderBanner): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            SliderBanner::deleteImage($sliderBanner);

            $originalName=$request->file("image")->getClientOriginalName();
            $extension=$request->file("image")->extension();
            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/slider-banners/"), $finalName);

            return $finalName;
        } else {
            return $sliderBanner->image;
        }
    }
}
