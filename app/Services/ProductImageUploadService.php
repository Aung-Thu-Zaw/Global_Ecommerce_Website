<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductImageUploadService
{
    public function createImage(Request $request): string
    {
        $request->validate([
            "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
        ]);


        $originalName=$request->file("image")->getClientOriginalName();
        $extension=$request->file("image")->extension();

        $finalName= Str::slug($originalName, '-')."."."$extension";

        $request->file("image")->move(storage_path("app/public/products/"), $finalName);

        return $finalName;
    }
}
