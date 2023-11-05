<?php

namespace App\Notifications\WebsiteSuggestion;

use App\Models\Suggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewSuggestionNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected Suggestion $suggestion)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<string>
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string|int>
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->suggestion->type === 'report_bug' ? 'A_NEW_SUGGESTION_ABOUT_OF_REPORTING_BUGS' : 'A_NEW_SUGGESTION_ABOUT_OF_FEATURE_REQUESTED',
            'suggestion' => $this->suggestion,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->suggestion->type === 'report_bug' ? 'A_NEW_SUGGESTION_ABOUT_OF_REPORTING_BUGS' : 'A_NEW_SUGGESTION_ABOUT_OF_FEATURE_REQUESTED',
            'suggestion' => $this->suggestion,
        ]);
    }
}
