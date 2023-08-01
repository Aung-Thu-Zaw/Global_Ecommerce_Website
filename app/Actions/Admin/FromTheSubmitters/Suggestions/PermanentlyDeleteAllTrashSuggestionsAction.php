<?php

namespace App\Actions\Admin\FromTheSubmitters\Subscribers;

use App\Models\Image;
use App\Models\Suggestion;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashSuggestionsAction
{
    /**
    * @param Collection<int,Suggestion> $suggestions
    */

    public function handle(Collection $suggestions): void
    {
        $suggestions->each(function ($suggestion) {

            $multiImages=Image::where("suggestion_id", $suggestion->id)->get();

            $multiImages->each(function ($image) {
                Image::deleteImage($image);
            });

            $suggestion->forceDelete();

        });
    }
}
