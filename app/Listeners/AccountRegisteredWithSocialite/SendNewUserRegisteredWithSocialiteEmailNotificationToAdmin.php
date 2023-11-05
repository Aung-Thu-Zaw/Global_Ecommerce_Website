<?php

namespace App\Listeners\AccountRegisteredWithSocialite;

use App\Models\User;
use App\Notifications\AccountRegistered\RegisteredUserEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewUserRegisteredWithSocialiteEmailNotificationToAdmin implements ShouldQueue
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
        $user = $event->user ?? null;

        $admins = User::where('role', 'admin')->get();

        Notification::send($admins, new RegisteredUserEmailNotification($user));
    }
}
