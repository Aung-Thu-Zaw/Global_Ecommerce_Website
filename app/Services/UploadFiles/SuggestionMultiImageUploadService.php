<?php

namespace App\Services\UploadFiles;

use App\Models\Image;
use App\Models\Suggestion;
use Illuminate\Http\UploadedFile;

class SuggestionMultiImageUploadService
{
    /**
     * @param  array<UploadedFile>  $images
     */
    public function createMultiImage(array $images, Suggestion $suggestion): void
    {
        foreach ($images as $image) {
            $originalName = $image->getClientOriginalName();

            $finalName = 'suggestion'.'-'.time().'-'.$originalName;

            $image->storeAs('suggestions', $finalName);

            Image::create(['suggestion_id' => $suggestion->id, 'img_path' => $finalName]);
        }
    }
}
