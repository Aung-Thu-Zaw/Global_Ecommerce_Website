<?php

namespace App\Listeners\AccountDeleted;

use App\Models\User;
use App\Notifications\AccountDeleted\UserAccountDeletedEmailNotification;
use App\Notifications\AccountDeleted\VendorAccountDeletedEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendUserAccountDeletedEmailNotificationToAdmin implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user=$event->user ?? null;

        $admins=User::where("role", "admin")->get();

        $user->role==="vendor" ?
        Notification::send($admins, new VendorAccountDeletedEmailNotification($user)) :
        Notification::send($admins, new UserAccountDeletedEmailNotification($user));
    }
}
