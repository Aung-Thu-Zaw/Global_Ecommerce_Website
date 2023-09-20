<?php

namespace App\Console\Commands;

use App\Actions\Admin\ShippingAreas\PermanentlyDeleteAllTrashTownshipAction;
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

        $brands = Township::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashTownshipAction())->handle($brands);
    }
}
