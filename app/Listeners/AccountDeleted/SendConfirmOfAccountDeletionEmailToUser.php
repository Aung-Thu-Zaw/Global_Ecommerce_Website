<?php

namespace App\Listeners\AccountDeleted;

use App\Mail\ConfirmOfAccountDeletionMail;
use Illuminate\Support\Facades\Mail;

class SendConfirmOfAccountDeletionEmailToUser
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

        Mail::to($user->email)->queue(new ConfirmOfAccountDeletionMail($user));
    }
}
