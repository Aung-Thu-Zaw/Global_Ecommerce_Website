<?php

namespace App\Actions\Admin\Languages;

use App\Models\Language;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashLanguageAction
{
    /**
    * @param Collection<int,Language> $languages
    */

    public function handle(Collection $languages): void
    {
        $languages->each(function ($language) {

            unlink(resource_path("lang/$language->short_name.json"));

            $language->forceDelete();

        });
    }
}
