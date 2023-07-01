<?php

namespace App\Notifications\WebsiteSuggestion;

use App\Models\Suggestion;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSuggestionEmailNotification extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
        ->subject("Report A New Suggestions")
        ->greeting("Dear ".$notifiable->name.",")
        ->line("We got a new suggestion from the submitter:")
        ->line("Submitter Email: ".$this->suggestion->email)
        ->line("Report Date: ".$this->suggestion->created_at)
        ->action('See More Details', route('admin.suggestions.show', $this->suggestion->id));
    }
}
