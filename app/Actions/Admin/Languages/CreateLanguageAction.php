<?php

namespace App\Actions\Admin\Languages;

use App\Models\Language;

class CreateLanguageAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        Language::create([
            "name"=>$data["name"],
            "short_name"=>$data["short_name"],
        ]);

        $copyData=file_get_contents(resource_path("lang/en.json"));

        file_put_contents(resource_path('lang/'.$data['short_name'].'.json'), $copyData);
    }
}
