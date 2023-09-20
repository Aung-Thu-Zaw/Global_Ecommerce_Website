<?php

namespace App\Actions\Admin\ShippingAreas;

use App\Models\City;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashCityAction
{
    /**
    * @param Collection<int,City> $cities
    */

    public function handle(Collection $cities): void
    {
        $cities->each(function ($city) {


            $city->forceDelete();
        });
    }
}
