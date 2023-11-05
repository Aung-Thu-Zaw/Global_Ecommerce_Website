<?php

namespace App\Listeners\AccountRegisteredWithSocialite;

use App\Mail\ForTheRegisteredUser\RegisteredUserWelcomeMail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToRegisteredWithSocialiteUser
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
        $user = $event->user ?? null;

        Mail::to($user->email)->queue(new RegisteredUserWelcomeMail($user));
    }
}
