<?php

namespace App\Events;

use App\Models\LiveChat;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLiveChatAssignment implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public LiveChat $liveChat)
    {
        //
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('new-live-chat.assignment');
    }
}
