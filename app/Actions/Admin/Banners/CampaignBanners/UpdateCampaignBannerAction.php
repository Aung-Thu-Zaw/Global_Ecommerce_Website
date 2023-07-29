<?php

namespace App\Actions\Admin\Banners\CampaignBanners;

use App\Models\CampaignBanner;
use App\Services\CampaignBannerImageUploadService;

class UpdateCampaignBannerAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, CampaignBanner $campaignBanner): void
    {
        $image = isset($data["image"]) ? (new CampaignBannerImageUploadService())->updateImage($data["image"], $campaignBanner->image) : $campaignBanner->image;

        $campaignBanner->update([
            "url"=>$data["url"],
            "status"=>$data["status"],
            "image"=>$image
        ]);
    }
}
