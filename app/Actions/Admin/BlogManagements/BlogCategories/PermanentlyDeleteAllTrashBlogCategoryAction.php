<?php

namespace App\Actions\Admin\BlogManagements\BlogCategories;

use App\Models\BlogCategory;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashBlogCategoryAction
{
    /**
    * @param Collection<int,BlogCategory> $blogCategories
    */

    public function handle(Collection $blogCategories): void
    {
        $blogCategories->each(function ($blogCategory) {

            BlogCategory::deleteImage($blogCategory->image);

            $blogCategory->forceDelete();

        });
    }
}
