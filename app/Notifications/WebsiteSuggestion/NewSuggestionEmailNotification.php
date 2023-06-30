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
        ->line("A new subscriber has subscribed to the website newsletter. Here are the details:")
        ->line("Submitter Email: ".$this->suggestion->email)
        ->line("Type of Report: ".$this->suggestion->type==='request_feature' ? "Request New Feature" : "Report Bug")
        ->line("Report Date: ".Carbon::parse($this->suggestion->created_at)->format("Y-m-d"))
        ->action('See More Details', route('admin.suggestions.show', $this->suggestion->id));
    }
}
