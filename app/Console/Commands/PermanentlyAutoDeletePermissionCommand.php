<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class PermanentlyAutoDeletePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permissions in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $permissions=Permission::onlyTrashed()
                               ->where('deleted_at', '<=', $cutoffDate)
                               ->get();

        $permissions->each(function ($permission) {

            $permission->forceDelete();

        });
    }
}
