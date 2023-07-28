<?php

namespace App\Actions\Admin\Categories;

use App\Models\Category;
use App\Services\CategoryImageUploadService;

class UpdateCategoryAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, Category $category): void
    {
        $image = (new CategoryImageUploadService())->updateImage($data["image"] ?? null, $category->image);

        $category->update([
            "parent_id" => $data["parent_id"],
            "name" => $data["name"],
            "status" => $data["status"],
            "image" => $image
        ]);
    }

}
