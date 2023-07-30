<?php

namespace App\Actions\Admin\BlogManagements\BlogCategories;

use App\Models\BlogCategory;
use App\Services\BlogCategoryImageUploadService;

class CreateBlogCategoryAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        $image = isset($data["image"]) ? (new BlogCategoryImageUploadService())->createImage($data["image"]) : null;

        BlogCategory::create([
            "name"=>$data["name"],
            "status"=>$data["status"],
            "image"=>$image
        ]);
    }
}
