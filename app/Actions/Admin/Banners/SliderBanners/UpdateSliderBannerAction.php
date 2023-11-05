<?php

namespace App\Actions\Admin\Banners\SliderBanners;

use App\Models\SliderBanner;
use App\Services\UploadFiles\SliderBannerImageUploadService;

class UpdateSliderBannerAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data, SliderBanner $sliderBanner): void
    {
        $image = isset($data['image']) ? (new SliderBannerImageUploadService())->updateImage($data['image'], $sliderBanner->image) : $sliderBanner->image;

        $sliderBanner->update([
            'url' => $data['url'],
            'status' => $data['status'],
            'image' => $image,
        ]);
    }
}
