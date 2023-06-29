<?php

namespace App\Listeners\WebsiteSuggestion;

use App\Mail\ForTheSubmitters\ThankForSuggestionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendThankForSuggestionEmailToSuggestionSubmitter
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
        Mail::to($event->suggestion->email)->queue(new ThankForSuggestionMail($event->suggestion));
    }
}
