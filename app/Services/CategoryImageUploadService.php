<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;

class CategoryImageUploadService
{
    public function createImage(UploadedFile $image): ?string
    {
        $originalName=$image->getClientOriginalName();

        $image->move(storage_path("app/public/categories/"), $originalName);

        return $originalName;

    }

    public function updateImage(?UploadedFile $image, string $categoryImage): ?string
    {
        if($image && is_uploaded_file($image)) {

            Category::deleteImage($categoryImage);

            $originalName=$image->getClientOriginalName();

            $image->move(storage_path("app/public/categories/"), $originalName);

            return $originalName;

        } else {

            return $categoryImage;

        }

    }

}
