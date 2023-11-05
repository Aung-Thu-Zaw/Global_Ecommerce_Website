<?php

namespace App\Events;

use App\Models\WebsiteFeedback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FeedbackForWebsite
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public WebsiteFeedback $websiteFeedback;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WebsiteFeedback $websiteFeedback)
    {
        $this->websiteFeedback = $websiteFeedback;
    }
}
