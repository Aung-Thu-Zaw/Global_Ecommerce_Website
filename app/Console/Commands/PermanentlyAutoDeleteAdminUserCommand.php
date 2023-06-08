<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteAdminUserCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'admin_user:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin users in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $adminUsers=User::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $adminUsers->each(function ($adminUser) {
            User::deleteUserAvatar($adminUser);
            $adminUser->forceDelete();
        });
    }
}
