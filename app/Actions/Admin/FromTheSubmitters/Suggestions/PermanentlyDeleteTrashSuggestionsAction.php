<?php

namespace App\Actions\Admin\FromTheSubmitters\Suggestions;

use App\Models\Image;
use App\Models\Suggestion;

class PermanentlyDeleteTrashSuggestionsAction
{
    public function handle(Suggestion $suggestion): void
    {
        $multiImages = Image::where('suggestion_id', $suggestion->id)->get();

        $multiImages->each(function ($image) {
            Image::deleteImage($image);
        });

        $suggestion->forceDelete();
    }
}
