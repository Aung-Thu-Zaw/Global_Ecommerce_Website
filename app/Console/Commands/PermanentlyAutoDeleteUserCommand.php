<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteUserCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'user:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Users in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $users=User::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $users->each(function ($user) {
            User::deleteUserAvatar($user);
            $user->forceDelete();
        });
    }
}
