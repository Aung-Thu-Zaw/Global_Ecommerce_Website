<?php

namespace App\Actions\Admin\AdminWebControlArea\WebsitePages\TermsAndConditions;

use App\Models\Page;

class UpdateTermsAndConditionsAction
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
