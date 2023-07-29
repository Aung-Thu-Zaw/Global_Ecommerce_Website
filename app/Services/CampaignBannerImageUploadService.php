<?php

namespace App\Services;

use App\Models\CampaignBanner;
use Illuminate\Http\UploadedFile;

class CampaignBannerImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/campaign-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $campaignBannerImage): string
    {
        if(is_string($campaignBannerImage)) {

            CampaignBanner::deleteImage($campaignBannerImage);
        }

        $originalName=$image->getClientOriginalName();

        $finalName=time()."-".$originalName;

        $image->move(storage_path("app/public/campaign-banners/"), $finalName);

        return $finalName;
    }
}
