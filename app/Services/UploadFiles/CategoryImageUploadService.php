<?php

namespace App\Services\UploadFiles;

use App\Models\Category;
use Illuminate\Http\UploadedFile;

class CategoryImageUploadService
{
    public function createImage(UploadedFile $image): ?string
    {
        $originalName = $image->getClientOriginalName();

        $finalName = time().'-'.$originalName;

        $image->storeAs('categories', $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string|null $categoryImage): string
    {
        if (is_string($categoryImage)) {
            Category::deleteImage($categoryImage);
        }

        $originalName = $image->getClientOriginalName();

        $finalName = time().'-'.$originalName;

        $image->storeAs('categories', $finalName);

        return $finalName;
    }
}
