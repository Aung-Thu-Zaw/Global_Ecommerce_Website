<?php

namespace App\Notifications\ProductQuestions;

use App\Models\Product;
use App\Models\ProductAnswer;
use App\Models\ProductQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductQuestionAnswerFromSellerNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected Product $product, protected ProductAnswer $productAnswer)
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
            "message" => "YOUR_QUESTION_HAS_BEEN_ANSWERED_TO_BY_THE_SELLER",
            "product" => $this->product->slug,
            "answer" => $this->productAnswer->answer_text,
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
            "message" => "YOUR_QUESTION_HAS_BEEN_ANSWERED_TO_BY_THE_SELLER",
            "product" => $this->product->slug,
            "answer" => $this->productAnswer->answer_text,
        ]);
    }
}
