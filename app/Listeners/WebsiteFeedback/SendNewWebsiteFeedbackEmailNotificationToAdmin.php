<?php

namespace App\Listeners\WebsiteFeedback;

use App\Models\User;
use App\Notifications\WebsiteFeedback\NewWebsiteFeedbackEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewWebsiteFeedbackEmailNotificationToAdmin implements ShouldQueue
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
        $websiteFeedback = $event->websiteFeedback ?? null;

        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewWebsiteFeedbackEmailNotification($websiteFeedback));
    }
}
