<?php

namespace App\Services;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryImageUploadService
{
    public function uploadImage(Request $request): ?string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);


            $extension=$request->file("image")->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/subCategories/"), $finalName);

            return $finalName;
        } else {
            return null;
        }
    }

    public function updateImage(Request $request, object $subCategory): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            SubCategory::deleteImage($subCategory);

            $extension=$request->file("image")->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $request->file("image")->move(storage_path("app/public/subCategories/"), $finalName);

            return $finalName;
        } else {
            return $subCategory->image;
        }
    }
}
