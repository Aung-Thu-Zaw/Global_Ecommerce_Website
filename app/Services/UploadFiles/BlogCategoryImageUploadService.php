<?php

namespace App\Services\UploadFiles;

use App\Models\BlogCategory;
use Illuminate\Http\UploadedFile;

class BlogCategoryImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName = $image->getClientOriginalName();

        $finalName = time().'-'.$originalName;

        $image->storeAs('blog-categories', $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string|null $blogCategoryImage): string
    {
        if (is_string($blogCategoryImage)) {
            BlogCategory::deleteImage($blogCategoryImage);
        }

        $originalName = $image->getClientOriginalName();

        $finalName = time().'-'.$originalName;

        $image->storeAs('blog-categories', $finalName);

        return $finalName;
    }
}
