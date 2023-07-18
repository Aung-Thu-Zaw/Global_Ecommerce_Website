<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class PermanentlyAutoDeleteRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Roles in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $roles=Role::onlyTrashed()
                   ->where('deleted_at', '<=', $cutoffDate)
                   ->get();

        $roles->each(function ($role) {

            $role->forceDelete();

        });
    }
}
