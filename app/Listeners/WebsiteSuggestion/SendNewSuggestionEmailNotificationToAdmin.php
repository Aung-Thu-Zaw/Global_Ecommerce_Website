<?php

namespace App\Listeners\WebsiteSuggestion;

use App\Models\User;
use App\Notifications\WebsiteSuggestion\NewSuggestionEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewSuggestionEmailNotificationToAdmin implements ShouldQueue
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
        $suggestion=$event->suggestion ?? null;

        $admins=User::where("role", "admin")->get();
        Notification::send($admins, new NewSuggestionEmailNotification($suggestion));
    }
}
