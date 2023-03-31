<?php

namespace App\Services;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryImageUploadService
{
    public function createImage(Request $request): ?string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $file->move(storage_path("app/public/subCategories/"), $finalName);

            return $finalName;
        } else {
            return null;
        }
    }

    public function updateImage(Request $request, SubCategory $subCategory): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            SubCategory::deleteImage($subCategory);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $file->move(storage_path("app/public/subCategories/"), $finalName);

            return $finalName;
        } else {
            return $subCategory->image;
        }
    }
}
