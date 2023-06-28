<?php

namespace App\Listeners\AccountRegistered;

use App\Models\User;
use App\Notifications\AccountRegistered\RegisteredUserEmailNotification;
use App\Notifications\AccountRegistered\RegisteredVendorEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewUserRegisteredEmailNotificationToAdmin implements ShouldQueue
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
            Notification::send($admins, new RegisteredVendorEmailNotification($event->user)) :
            Notification::send($admins, new RegisteredUserEmailNotification($event->user));
    }
}
