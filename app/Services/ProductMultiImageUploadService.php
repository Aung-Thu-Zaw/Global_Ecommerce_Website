<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductMultiImageUploadService
{
    public function createMultiImage(Request $request, $product)
    {
        $request->validate([
            "multi_image"=>["required","array"]
        ]);

        foreach ($request->multi_image as $image) {
            $originalName=$image->getClientOriginalName();
            $extension=$image->extension();

            $finalName= Str::slug($originalName, '-')."."."$extension";

            $image->move(storage_path("app/public/products/"), $finalName);


            $image=new Image();
            $image->product_id=$product->id;
            $image->name=$finalName;
            $image->save();
        }
    }


    // public function updateImage(Request $request, object $category): string
    // {
    //     if ($request->hasFile("image")) {
    //         $request->validate([
    //             "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
    //         ]);

    //         Category::deleteImage($category);

    //         $extension=$request->file("image")->extension();
    //         $finalName= Str::slug($request->name, '-')."."."$extension";

    //         $request->file("image")->move(storage_path("app/public/categories/"), $finalName);

    //         return $finalName;
    //     } else {
    //         return $category->image;
    //     }
    // }
}
