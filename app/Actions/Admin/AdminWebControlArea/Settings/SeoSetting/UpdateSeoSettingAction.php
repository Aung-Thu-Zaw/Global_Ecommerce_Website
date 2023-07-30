<?php

namespace App\Actions\Admin\AdminWebControlArea\Settings\SeoSetting;

use App\Models\SeoSetting;

class UpdateSeoSettingAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, SeoSetting $seoSetting): void
    {
        $seoSetting->update([
            "meta_title"=>$data["meta_title"],
            "meta_author"=>$data["meta_author"],
            "meta_keyword"=>$data["meta_keyword"],
            "meta_description"=>$data["meta_description"],
        ]);
    }
}
