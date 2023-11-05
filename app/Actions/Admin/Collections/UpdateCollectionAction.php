<?php

namespace App\Actions\Admin\Collections;

use App\Models\Collection;

class UpdateCollectionAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data, Collection $collection): void
    {
        $collection->update([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    }
}
