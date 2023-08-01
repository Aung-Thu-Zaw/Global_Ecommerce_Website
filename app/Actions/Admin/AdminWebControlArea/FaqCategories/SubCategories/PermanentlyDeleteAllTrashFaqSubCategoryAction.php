<?php

namespace App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories;

use App\Models\FaqSubCategory;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashFaqSubCategoryAction
{
    /**
    * @param Collection<int,FaqSubCategory> $faqSubCategories
    */

    public function handle(Collection $faqSubCategories): void
    {
        $faqSubCategories->each(function ($faqSubCategory) {

            $faqSubCategory->forceDelete();

        });
    }
}
