<?php

namespace App\Actions\Admin\BlogManagements\BlogCategories;

use App\Models\BlogCategory;
use App\Services\UploadFiles\BlogCategoryImageUploadService;

class UpdateBlogCategoryAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data, BlogCategory $blogCategory): void
    {
        $image = isset($data['image']) ? (new BlogCategoryImageUploadService())->updateImage($data['image'], $blogCategory->image) : $blogCategory->image;

        $blogCategory->update([
            'name' => $data['name'],
            'status' => $data['status'],
            'image' => $image,
        ]);
    }
}
