<?php

namespace App\Actions\Admin\AdminWebControlArea\WebsitePages\PrivacyPolicy;

use App\Models\Page;
use App\Models\SeoSetting;

class UpdatePrivacyPolicyAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, Page $page): void
    {
        $page->update([
            "title"=>$data["title"],
            "description"=>$data["description"],
        ]);
    }
}
