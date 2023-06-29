<?php

namespace App\Listeners\SubscribedNewsletter;

use App\Models\User;
use App\Notifications\SubscribedNewsletter\NewsletterSubscribedEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewSubscriberEmailNotificationToAdmin implements ShouldQueue
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
        Notification::send($admins, new NewsletterSubscribedEmailNotification($event->subscriber));
    }
}
