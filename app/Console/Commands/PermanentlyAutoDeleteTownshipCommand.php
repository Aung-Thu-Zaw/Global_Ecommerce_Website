<?php

namespace App\Console\Commands;

use App\Models\Township;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteTownshipCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'township:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Townships in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $townships=Township::onlyTrashed()
                           ->where('deleted_at', '<=', $cutoffDate)
                           ->get();

        $townships->each(function ($township) {

            $township->forceDelete();

        });
    }
}
