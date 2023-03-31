<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductImageUploadService
{
    public function createImage(Request $request): string
    {
        $request->validate([
            "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
        ]);

        $file=$request->file("image");

        /** @var \Illuminate\Http\UploadedFile $file */


        $extension=$file->extension();

        $finalName= Str::slug($request->name, '-')."."."$extension";

        $file->move(storage_path("app/public/products/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, Product $product): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            Product::deleteImage($product);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $file->move(storage_path("app/public/products/"), $finalName);

            return $finalName;
        } else {
            return $product->image;
        }
    }
}
