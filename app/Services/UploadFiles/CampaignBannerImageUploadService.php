<?php

namespace App\Services\UploadFiles;

use App\Models\CampaignBanner;
use Illuminate\Http\UploadedFile;

class CampaignBannerImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName = $image->getClientOriginalName();

        $finalName = time().'-'.$originalName;

        $image->storeAs('campaign-banners', $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $campaignBannerImage): string
    {
        if (is_string($campaignBannerImage)) {
            CampaignBanner::deleteImage($campaignBannerImage);
        }

        $originalName = $image->getClientOriginalName();

        $finalName = time().'-'.$originalName;

        $image->storeAs('campaign-banners', $finalName);

        return $finalName;
    }
}
