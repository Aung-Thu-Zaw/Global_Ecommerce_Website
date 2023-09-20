<?php

namespace App\Console\Commands;

use App\Actions\Admin\ShippingAreas\PermanentlyDeleteAllTrashCityAction;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteCityCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'city:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cities in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $brands = City::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashCityAction())->handle($brands);
    }
}
