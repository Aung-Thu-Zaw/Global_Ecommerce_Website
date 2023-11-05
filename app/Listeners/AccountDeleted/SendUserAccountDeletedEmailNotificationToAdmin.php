<?php

namespace App\Listeners\AccountDeleted;

use App\Models\User;
use App\Notifications\AccountDeleted\SellerAccountDeletedEmailNotification;
use App\Notifications\AccountDeleted\UserAccountDeletedEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        $user = $event->user ?? null;

        $admins = User::where('role', 'admin')->get();

        $user->role === 'seller' ?
        Notification::send($admins, new SellerAccountDeletedEmailNotification($user)) :
        Notification::send($admins, new UserAccountDeletedEmailNotification($user));
    }
}
