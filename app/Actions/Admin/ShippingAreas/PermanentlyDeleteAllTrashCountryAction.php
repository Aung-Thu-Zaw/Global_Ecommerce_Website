<?php

namespace App\Actions\Admin\ShippingAreas;

use App\Models\Country;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashCountryAction
{
    /**
    * @param Collection<int,Country> $countries
    */

    public function handle(Collection $countries): void
    {
        $countries->each(function ($country) {


            $country->forceDelete();
        });
    }
}
