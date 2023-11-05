<?php

namespace App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories;

use App\Models\FaqCategory;

class UpdateFaqCategoryAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data, FaqCategory $faqCategory): void
    {
        $faqCategory->update([
            'name' => $data['name'],
        ]);
    }
}
