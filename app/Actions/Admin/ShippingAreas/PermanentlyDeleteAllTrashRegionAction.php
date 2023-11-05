<?php

namespace App\Actions\Admin\ShippingAreas;

use App\Models\Region;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashRegionAction
{
    /**
     * @param  Collection<int,Region>  $regions
     */
    public function handle(Collection $regions): void
    {
        $regions->each(function ($region) {
            $region->forceDelete();
        });
    }
}
