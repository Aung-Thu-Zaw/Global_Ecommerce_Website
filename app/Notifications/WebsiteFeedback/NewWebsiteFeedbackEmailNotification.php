<?php

namespace App\Notifications\WebsiteFeedback;

use App\Models\WebsiteFeedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewWebsiteFeedbackEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected WebsiteFeedback $websiteFeedback)
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
        ->subject("New Website Feedback Received")
        ->greeting("Dear ".$notifiable->name.",")
        ->line("We got a new feedback from the submitter:")
        ->line("Submitter Email: ".$this->websiteFeedback->email)
        ->line("Date: ".$this->websiteFeedback->created_at)
        ->action('See More Details', route('admin.website-feedbacks.show', $this->websiteFeedback->id));
    }
}
