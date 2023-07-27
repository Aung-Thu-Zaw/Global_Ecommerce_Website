<?php

namespace App\Actions\Admin\Collections;

use App\Models\Collection;

class CreateCollectionAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        Collection::create([
            "title"=>$data["title"],
            "description"=>$data["description"],
        ]);
    }
}
