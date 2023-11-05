<?php

namespace App\Listeners\AccountDeleted;

use App\Models\User;
use App\Notifications\AccountDeleted\UserAccountDeletedNotification;
use Illuminate\Support\Facades\Notification;

class SendUserAccountDeletedNotificationToAdminDashboard
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

        Notification::send($admins, new UserAccountDeletedNotification($user));
    }
}
