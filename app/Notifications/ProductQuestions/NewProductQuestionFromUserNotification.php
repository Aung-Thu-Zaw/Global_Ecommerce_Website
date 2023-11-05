<?php

namespace App\Notifications\ProductQuestions;

use App\Models\Product;
use App\Models\ProductQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewProductQuestionFromUserNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected ProductQuestion $productQuestion, protected Product $product)
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
            'message' => 'YOUR_PRODUCT_HAS_RECEIVED_A_NEW_QUESTION_FROM_A_CUSTOMER',
            'product' => $this->product->slug,
            'question' => $this->productQuestion->question_text,

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
            'message' => 'YOUR_PRODUCT_HAS_RECEIVED_A_NEW_QUESTION_FROM_A_CUSTOMER',
            'product' => $this->product->slug,
            'question' => $this->productQuestion->question_text,

        ]);
    }
}
