<?php

namespace App\Actions\Admin\ShippingAreas;

use App\Models\Township;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashTownshipAction
{
    /**
     * @param  Collection<int,Township>  $townships
     */
    public function handle(Collection $townships): void
    {
        $townships->each(function ($township) {
            $township->forceDelete();
        });
    }
}
