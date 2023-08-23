<?php

namespace App\Listeners\AccountRegistered;

use App\Mail\ForTheRegisteredUser\RegisteredUserWelcomeMail;
use App\Mail\ForTheRegisteredUser\RegisteredSellerWelcomeMail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToRegisteredUser
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

        $user->role === "user" ?
        Mail::to($user->email)->queue(new RegisteredUserWelcomeMail($user)) :
        Mail::to($user->email)->queue(new RegisteredSellerWelcomeMail($user));

    }
}
