<?php

namespace App\Actions\Admin\Categories;

use App\Models\Category;
use App\Services\CategoryImageUploadService;

class CreateCategoryAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        $image=null;

        if(isset($data["image"])) {

            $image=(new CategoryImageUploadService())->createImage($data["image"]);
        }

        Category::create([
            "parent_id"=>$data["parent_id"],
            "name"=>$data["name"],
            "status"=>$data["status"],
            "image"=>$image
        ]);
    }
}
