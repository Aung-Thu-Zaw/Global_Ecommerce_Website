<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductMultiImageUploadService
{
    public function createMultiImage(Request $request, Product $product): void
    {
        if ($request->multi_image) {
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
                $image->img_path=$finalName;
                $image->save();
            }
        }
    }
}
