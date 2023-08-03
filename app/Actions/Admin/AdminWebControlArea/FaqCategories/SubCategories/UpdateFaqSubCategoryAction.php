<?php

namespace App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories;

use App\Models\FaqSubCategory;

class UpdateFaqSubCategoryAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, FaqSubCategory $faqSubCategory): void
    {
        $faqSubCategory->update([
            "icon"=>$data["icon"],
            "faq_category_id"=>$data["faq_category_id"],
            "name"=>$data["name"],
        ]);
    }
}
