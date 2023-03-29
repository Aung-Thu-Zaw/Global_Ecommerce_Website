<?php

namespace App\Services;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SliderImageUploadService
{
    public function createImage(Request $request): string
    {
        $request->validate([
            "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
        ]);

        $originalName=$request->file("image")->getClientOriginalName();


        $extension=$request->file("image")->extension();
        $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

        $request->file("image")->move(storage_path("app/public/sliders/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, object $slider): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            Slider::deleteImage($slider);

            $originalName=$request->file("image")->getClientOriginalName();
            $extension=$request->file("image")->extension();
            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/sliders/"), $finalName);

            return $finalName;
        } else {
            return $slider->image;
        }
    }
}
