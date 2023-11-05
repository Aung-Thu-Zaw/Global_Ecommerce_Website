<?php

namespace App\Listeners\AccountRegistered;

use App\Models\User;
use App\Notifications\AccountRegistered\RegisteredSellerEmailNotification;
use App\Notifications\AccountRegistered\RegisteredUserEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        $user = $event->user ?? null;

        $admins = User::where('role', 'admin')->get();

        $user->role === 'seller' ?
            Notification::send($admins, new RegisteredSellerEmailNotification($user)) :
            Notification::send($admins, new RegisteredUserEmailNotification($user));
    }
}
