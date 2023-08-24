<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Suggestion;
use Illuminate\Http\UploadedFile;

class SuggestionMultiImageUploadService
{
    /**
     * @param array<UploadedFile> $images
     */
    public function createMultiImage(array $images, Suggestion $suggestion): void
    {
        foreach ($images as $image) {

            $originalName = $image->getClientOriginalName();

            $finalName = "suggestion"."-".time()."-".$originalName;

            $image->move(storage_path("app/public/suggestions/"), $finalName);

            $image = new Image();
            $image->suggestion_id = $suggestion->id;
            $image->img_path = $finalName;
            $image->save();
        }
    }
}
