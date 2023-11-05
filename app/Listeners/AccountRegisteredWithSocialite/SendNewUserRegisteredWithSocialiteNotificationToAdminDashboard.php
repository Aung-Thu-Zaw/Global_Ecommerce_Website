<?php

namespace App\Listeners\AccountRegisteredWithSocialite;

use App\Models\User;
use App\Notifications\AccountRegistered\RegisteredUserNotification;
use Illuminate\Support\Facades\Notification;

class SendNewUserRegisteredWithSocialiteNotificationToAdminDashboard
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

        Notification::send($admins, new RegisteredUserNotification($user));
    }
}
