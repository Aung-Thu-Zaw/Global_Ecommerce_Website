<?php

namespace App\Events;

use App\Models\LiveChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveChatMessageDeleted implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public LiveChatMessage $liveChatMessage)
    {
        //
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('live-chat.message');
    }
}
