<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuggestionMultiImageUploadService
{
    public function createMultiImage(Request $request, Suggestion $suggestion): void
    {
        if ($request->multi_image) {
            $request->validate([
                "multi_image"=>["required","array"]
            ]);

            foreach ($request->multi_image as $image) {
                $originalName=$image->getClientOriginalName();
                $extension=$image->extension();

                $finalName= Str::slug('suggestion-'.$originalName, '-')."."."$extension";

                $image->move(storage_path("app/public/suggestions/"), $finalName);


                $image=new Image();
                $image->suggestion_id=$suggestion->id;
                $image->img_path=$finalName;
                $image->save();
            }
        }
    }
}
