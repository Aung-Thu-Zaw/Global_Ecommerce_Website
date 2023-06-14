<?php

namespace App\Listeners\Registered;

use App\Models\User;
use App\Notifications\Registered\RegisteredUserEmailNotification;
use App\Notifications\Registered\RegisteredVendorEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewUserRegisteredEmailNotificationForAdmin implements ShouldQueue
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
