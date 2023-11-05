<?php

namespace App\Listeners\SubscribedNewsletter;

use App\Models\User;
use App\Notifications\SubscribedNewsletter\NewsletterSubscribedNotification;
use Illuminate\Support\Facades\Notification;

class SendNewSubscriberNotificationToAdminDashboard
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
        $subscriber = $event->subscriber ?? null;
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewsletterSubscribedNotification($subscriber));
    }
}
