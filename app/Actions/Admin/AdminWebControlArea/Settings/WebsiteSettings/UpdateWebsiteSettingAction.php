<?php

namespace App\Actions\Admin\AdminWebControlArea\Settings\WebsiteSettings;

use App\Models\WebsiteSetting;
use App\Services\UploadFiles\WebsiteSettingImageUploadService;

class UpdateWebsiteSettingAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, WebsiteSetting $websiteSetting): void
    {
        $logo = isset($data["logo"]) ? (new WebsiteSettingImageUploadService())->uploadLogo($data["logo"], $websiteSetting->logo) : $websiteSetting->logo;

        $favicon = isset($data["favicon"]) ? (new WebsiteSettingImageUploadService())->uploadFavicon($data["favicon"], $websiteSetting->favicon) : $websiteSetting->favicon;

        $websiteSetting->update([
            "logo" => $logo,
            "favicon" => $favicon,
            "phone" => $data["phone"],
            "support_phone" => $data["support_phone"],
            "email" => $data["email"],
            "company_address" => $data["company_address"],
            "copyright" => $data["copyright"],
            "facebook" => $data["facebook"],
            "twitter" => $data["twitter"],
            "instagram" => $data["instagram"],
            "youtube" => $data["youtube"],
            "reddit" => $data["reddit"],
            "linked_in" => $data["linked_in"],
        ]);
    }
}
