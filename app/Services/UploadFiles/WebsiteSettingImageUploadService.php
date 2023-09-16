<?php

namespace App\Services\UploadFiles;

use App\Models\WebsiteSetting;
use Illuminate\Http\UploadedFile;

class WebsiteSettingImageUploadService
{
    public function uploadLogo(UploadedFile $image, string|null $logoImage): string
    {
        if(is_string($logoImage)) {

            WebsiteSetting::deleteLogo($logoImage);
        }

        $originalName = $image->getClientOriginalName();

        $finalName = time()."-".$originalName;

        $image->storeAs("website-settings", $finalName);

        return $finalName;
    }

    public function uploadFavicon(UploadedFile $image, string|null $faviconImage): string
    {
        if(is_string($faviconImage)) {

            WebsiteSetting::deleteFavicon($faviconImage);
        }

        $originalName = $image->getClientOriginalName();

        $finalName = time()."-".$originalName;

        $image->storeAs("website-settings", $finalName);

        return $finalName;
    }
}
