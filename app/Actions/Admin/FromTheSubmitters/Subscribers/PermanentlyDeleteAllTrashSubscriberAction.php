<?php

namespace App\Actions\Admin\FromTheSubmitters\Subscribers;

use App\Models\Subscriber;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashSubscriberAction
{
    /**
     * @param  Collection<int,Subscriber>  $subscribers
     */
    public function handle(Collection $subscribers): void
    {
        $subscribers->each(function ($subscriber) {
            $subscriber->forceDelete();
        });
    }
}
