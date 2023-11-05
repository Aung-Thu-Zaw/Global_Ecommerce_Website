<?php

namespace App\Console\Commands;

use App\Actions\Admin\ShippingAreas\PermanentlyDeleteAllTrashCountryAction;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteCountryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Countries in the trash will be automatically deleted after 60 days';

    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $brands = Country::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashCountryAction())->handle($brands);
    }
}
