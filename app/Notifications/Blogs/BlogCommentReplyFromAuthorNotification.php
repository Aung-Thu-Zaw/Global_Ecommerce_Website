<?php

namespace App\Notifications\Blogs;

use App\Models\BlogCommentReply;
use App\Models\BlogPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BlogCommentReplyFromAuthorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected BlogPost $blogPost, protected BlogCommentReply $blogCommentReply)
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
            'message' => 'YOUR_COMMENT_HAS_BEEN_REPLIED_TO_BY_THE_AUTHOR',
            'blog' => $this->blogPost->slug,
            'reply' => $this->blogCommentReply->reply_text,
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
            'message' => 'YOUR_COMMENT_HAS_BEEN_REPLIED_TO_BY_THE_AUTHOR',
            'blog' => $this->blogPost->slug,
            'reply' => $this->blogCommentReply->reply_text,
        ]);
    }
}
