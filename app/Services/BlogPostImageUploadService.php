<?php

namespace App\Services;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostImageUploadService
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

        $file->move(storage_path("app/public/blog-posts/"), $finalName);

        return $finalName;
    }

    public function updateImage(Request $request, BlogPost $blogPost): string
    {
        if ($request->hasFile("image")) {
            $request->validate([
                "image"=>["required","image","mimes:png,jpg,jpeg,svg,webp,gif"]
            ]);

            BlogPost::deleteImage($blogPost);

            $file=$request->file("image");

            /** @var \Illuminate\Http\UploadedFile $file */

            $extension=$file->extension();
            $finalName= Str::slug($request->name, '-')."."."$extension";

            $file->move(storage_path("app/public/blog-posts/"), $finalName);

            return $finalName;
        } else {
            return $blogPost->image;
        }
    }
}
