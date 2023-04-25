<?php

namespace App\Services;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebsiteSettingImageUploadService
{
    public function uploadLogo(Request $request, WebsiteSetting $websiteSetting): string
    {
        if ($request->hasFile("logo")) {

            $request->validate([
                "logo"=>["nullable","image","mimes:png,jpg,jpeg,webp,gif"],
            ]);

            WebsiteSetting::deleteLogo($websiteSetting);


            /** @var \Illuminate\Http\UploadedFile $file */

            $file=$request->file("logo");

            $originalName=$file->getClientOriginalName();

            $extension=$file->extension();

            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $file->move(storage_path("app/public/website-settings/"), $finalName);

            return $finalName;
        } else {
            return $websiteSetting->logo;
        }
    }


    public function uploadFavicon(Request $request, WebsiteSetting $websiteSetting): string
    {
        if ($request->hasFile("favicon")) {
            $request->validate([
                "favicon"=>["nullable","image","mimes:png,jpg,jpeg,webp,gif"],
            ]);

            WebsiteSetting::deleteFavicon($websiteSetting);

            /** @var \Illuminate\Http\UploadedFile $file */
            $file=$request->file("favicon");


            $originalName=$file->getClientOriginalName();

            $extension=$file->extension();

            $finalName= Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-')."."."$extension";

            $file->move(storage_path("app/public/website-settings/"), $finalName);

            return $finalName;
        } else {
            return $websiteSetting->favicon;
        }
    }
}
