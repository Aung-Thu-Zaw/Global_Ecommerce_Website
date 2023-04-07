<?php

namespace App\Services;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionImageUploadService
{
    public function createImage(Request $request): string
    {
        $request->validate([
            "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
        ]);


        $file=$request->file("image");

        /** @var \Illuminate\Http\UploadedFile $file */

        $extension=$file->extension();

        $finalName= Str::slug($request->title, '-')."."."$extension";

        $file->move(storage_path("app/public/collections/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, Collection $collection): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            Collection::deleteImage($collection);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->title, '-')."."."$extension";

            $file->move(storage_path("app/public/collections/"), $finalName);

            return $finalName;
        } else {
            return $collection->image;
        }
    }
}
