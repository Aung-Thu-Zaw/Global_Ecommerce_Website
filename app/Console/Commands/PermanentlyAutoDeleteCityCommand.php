<?php

namespace App\Console\Commands;

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
    protected $description = 'Cities in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $cities=City::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $cities->each(function ($city) {
            $city->forceDelete();
        });
    }
}
