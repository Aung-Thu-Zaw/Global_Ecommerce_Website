<?php

namespace App\Notifications\Reviews;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AdminPublishedProductReviewNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected ProductReview $productReview, protected Product $product)
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
            'message' => 'ADMIN_PUBLISHED_PRODUCT_REVIEW_IN_YOUR_PRODUCT',
            'review' => $this->productReview,
            'slug' => $this->product->slug,
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
            'message' => 'ADMIN_PUBLISHED_PRODUCT_REVIEW_IN_YOUR_PRODUCT',
            'review' => $this->productReview,
            'slug' => $this->product->slug,
        ]);
    }
}
