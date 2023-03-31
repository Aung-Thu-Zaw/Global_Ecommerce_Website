<?php

namespace App\Services;

use App\Models\CampaignBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignBannerImageUploadService
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

        $file->move(storage_path("app/public/campaign-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, CampaignBanner $campaignBanner): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            CampaignBanner::deleteImage($campaignBanner);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $originalName=$file->getClientOriginalName();
            $extension=$file->extension();
            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $file->move(storage_path("app/public/campaign-banners/"), $finalName);

            return $finalName;
        } else {
            return $campaignBanner->image;
        }
    }
}
