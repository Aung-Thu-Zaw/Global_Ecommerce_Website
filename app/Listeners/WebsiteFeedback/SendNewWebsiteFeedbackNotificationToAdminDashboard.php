<?php

namespace App\Listeners\WebsiteFeedback;

use App\Models\User;
use App\Notifications\WebsiteFeedback\NewWebsiteFeedbackNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewWebsiteFeedbackNotificationToAdminDashboard
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
        $admins = User::where("role", "admin")->get();
        Notification::send($admins, new NewWebsiteFeedbackNotification($websiteFeedback));
    }
}
