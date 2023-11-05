<?php

namespace App\Listeners\SubscribedNewsletter;

use App\Mail\ForTheSubmitters\ThankForSubscribeWebsiteMail;
use Illuminate\Support\Facades\Mail;

class SendThankForSubscribeWebsiteEmailToSubscriber
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
        $subscriber = $event->subscriber ?? null;

        Mail::to($subscriber->email)->queue(new ThankForSubscribeWebsiteMail());
    }
}
