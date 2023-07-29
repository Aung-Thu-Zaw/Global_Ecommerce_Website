<?php

namespace App\Services;

use App\Models\SliderBanner;
use Illuminate\Http\UploadedFile;

class SliderBannerImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/slider-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $sliderBannerImage): string
    {
        if(is_string($sliderBannerImage)) {

            SliderBanner::deleteImage($sliderBannerImage);
        }

        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/slider-banners/"), $finalName);

        return $finalName;
    }
}
