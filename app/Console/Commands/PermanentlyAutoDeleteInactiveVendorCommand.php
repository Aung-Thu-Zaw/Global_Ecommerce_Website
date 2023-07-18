<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteInactiveVendorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactive_vendor:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inactive Vendors in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $inactiveVendors=User::onlyTrashed()
                             ->where('deleted_at', '<=', $cutoffDate)
                             ->where("role", "vendor")
                             ->get();

        $inactiveVendors->each(function ($inactiveVendor) {

            User::deleteUserAvatar($inactiveVendor);

            $inactiveVendor->forceDelete();

        });
    }
}
