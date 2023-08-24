<?php

namespace App\Actions\Ecommerce;

use App\Models\Suggestion;
use App\Services\SuggestionMultiImageUploadService;

class CreateSuggestionAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): Suggestion
    {
        $suggestion = Suggestion::create([
            "email" => $data["email"],
            "description" => $data["description"],
            "type" => $data["type"],
        ]);

        if(isset($data["multi_image"])) {

            (new SuggestionMultiImageUploadService())->createMultiImage($data["multi_image"], $suggestion);

        }

        return $suggestion;

    }
}
