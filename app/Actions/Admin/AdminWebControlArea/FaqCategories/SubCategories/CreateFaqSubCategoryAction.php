<?php

namespace App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories;

use App\Models\FaqSubCategory;

class CreateFaqSubCategoryAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): void
    {
        FaqSubCategory::create([
            'icon' => $data['icon'],
            'faq_category_id' => $data['faq_category_id'],
            'name' => $data['name'],
        ]);
    }
}
