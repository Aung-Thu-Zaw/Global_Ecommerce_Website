<?php

namespace App\Listeners\Registered;

use App\Mail\ForTheRegisteredUser\RegisteredUserWelcomeMail;
use App\Mail\ForTheRegisteredUser\RegisteredVendorWelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToRegisteredAccount
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
        $event->user->role ==="user" ?
        Mail::to($event->user->email)->queue(new RegisteredUserWelcomeMail($event->user)) :
        Mail::to($event->user->email)->queue(new RegisteredVendorWelcomeMail($event->user));

    }
}
