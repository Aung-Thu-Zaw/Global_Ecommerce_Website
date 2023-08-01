<?php

namespace App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories;

use App\Models\FaqCategory;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashFaqCategoryAction
{
    /**
    * @param Collection<int,FaqCategory> $faqCategories
    */

    public function handle(Collection $faqCategories): void
    {
        $faqCategories->each(function ($faqCategory) {

            $faqCategory->forceDelete();

        });
    }
}
