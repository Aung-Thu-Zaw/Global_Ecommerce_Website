<?php

namespace App\Actions\Admin\Languages;

use App\Models\Language;

class UpdateLanguageAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, Language $language): void
    {
        $language->update([
            "name"=>$data["name"],
            "short_name"=>$data["short_name"],
        ]);
    }
}
