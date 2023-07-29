<?php

namespace App\Actions\Admin\Banners\CampaignBanners;

use App\Models\CampaignBanner;
use App\Services\CampaignBannerImageUploadService;

class CreateCampaignBannerAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        $image = isset($data["image"]) ? (new CampaignBannerImageUploadService())->createImage($data["image"]) : null;

        CampaignBanner::create([
            "url"=>$data["url"],
            "status"=>"hide",
            "image"=>$image
        ]);
    }
}
