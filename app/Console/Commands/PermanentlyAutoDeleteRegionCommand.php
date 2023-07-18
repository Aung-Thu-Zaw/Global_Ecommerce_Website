<?php

namespace App\Console\Commands;

use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteRegionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'region:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regions in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $regions=Region::onlyTrashed()
                       ->where('deleted_at', '<=', $cutoffDate)
                       ->get();

        $regions->each(function ($region) {

            $region->forceDelete();

        });
    }
}
