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
        $admins=User::where("role", "admin")->get();

        $event->user->role==="vendor" ?
        Notification::send($admins, new VendorAccountDeletedEmailNotification($event->user)) :
        Notification::send($admins, new UserAccountDeletedEmailNotification($event->user));
    }
}
