<?php

namespace App\Listeners\WebsiteSuggestion;

use App\Models\User;
use App\Notifications\WebsiteSuggestion\NewSuggestionNotification;
use Illuminate\Support\Facades\Notification;

class SendNewSuggestionNotificationToAdminDashboard
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
        $suggestion = $event->suggestion ?? null;
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewSuggestionNotification($suggestion));
    }
}
