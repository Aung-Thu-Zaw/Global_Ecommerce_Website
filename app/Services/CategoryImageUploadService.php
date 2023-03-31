<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryImageUploadService
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

            $file->move(storage_path("app/public/categories/"), $finalName);

            return $finalName;
        } else {
            return null;
        }
    }

    public function updateImage(Request $request, Category $category): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            Category::deleteImage($category);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $file->move(storage_path("app/public/categories/"), $finalName);

            return $finalName;
        } else {
            return $category->image;
        }
    }
}
