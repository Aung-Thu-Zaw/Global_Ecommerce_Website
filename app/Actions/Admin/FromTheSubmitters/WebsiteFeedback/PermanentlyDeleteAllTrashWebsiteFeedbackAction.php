<?php

namespace App\Actions\Admin\FromTheSubmitters\Subscribers;

use App\Models\WebsiteFeedback;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashWebsiteFeedbackAction
{
    /**
    * @param Collection<int,WebsiteFeedback> $websiteFeedbacks
    */

    public function handle(Collection $websiteFeedbacks): void
    {
        $websiteFeedbacks->each(function ($websiteFeedback) {

            $websiteFeedback->forceDelete();

        });
    }
}
