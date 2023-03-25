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


        $extension=$request->file("image")->extension();

        $finalName= Str::slug($request->name, '-')."."."$extension";

        $request->file("image")->move(storage_path("app/public/products/"), $finalName);

        return $finalName;
    }
}
