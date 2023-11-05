<?php

namespace App\Actions\Admin\Banners\SliderBanners;

use App\Models\SliderBanner;
use App\Services\UploadFiles\SliderBannerImageUploadService;

class CreateSliderBannerAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): void
    {
        $image = isset($data['image']) ? (new SliderBannerImageUploadService())->createImage($data['image']) : null;

        SliderBanner::create([
            'url' => $data['url'],
            'status' => 'hide',
            'image' => $image,
        ]);
    }
}
