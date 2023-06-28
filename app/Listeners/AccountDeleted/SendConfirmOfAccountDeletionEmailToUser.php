<?php

namespace App\Listeners\AccountDeleted;

use App\Mail\ConfirmOfAccountDeletionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        Mail::to($event->user->email)->queue(new ConfirmOfAccountDeletionMail($event->user));
    }
}
