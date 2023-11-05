<?php

namespace App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories;

use App\Models\FaqCategory;

class CreateFaqCategoryAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): void
    {
        FaqCategory::create([
            'name' => $data['name'],
        ]);
    }
}
