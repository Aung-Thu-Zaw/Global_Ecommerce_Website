<?php

namespace App\Listeners\WebsiteFeedback;

use App\Mail\ForTheSubmitters\ThankForWebsiteFeedbackMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendThankForFeedbackEmailToFeedbackSubmitter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $websiteFeedback = $event->websiteFeedback ?? null;
        Mail::to($websiteFeedback->email)->queue(new ThankForWebsiteFeedbackMail($websiteFeedback));

    }
}
