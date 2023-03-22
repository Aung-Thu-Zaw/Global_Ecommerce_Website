<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryImageUploadService
{
    public function uploadImage(Request $request): ?string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);


            $extension=$request->file("image")->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/categories/"), $finalName);

            return $finalName;
        } else {
            return null;
        }
    }

    public function updateImage(Request $request, object $category): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            Category::deleteImage($category);

            $extension=$request->file("image")->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/categories/"), $finalName);

            return $finalName;
        } else {
            return $category->image;
        }
    }
}
