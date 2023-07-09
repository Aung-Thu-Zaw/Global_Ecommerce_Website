<?php

namespace App\Events;

use App\Models\Suggestion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SuggestionForWebsite
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Suggestion $suggestion;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Suggestion $suggestion)
    {
        $this->suggestion=$suggestion;
    }
}
