<?php

namespace App\Mail\ForTheSubmitters;

use App\Models\Suggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ThankForSuggestionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected Suggestion $suggestion)
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('noreply@support.globalecommerce.com', 'Global E-commerce'),
            subject: $this->suggestion->type==='request_feature' ? 'Thank you for Your Feature Request on Global E-commerce Website' : ' Thank you for Reporting Bugs on Global E-commerce Website',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: $this->suggestion->type==='request_feature' ? 'mails.for-submitters.thanks-for-request-features-mail' : 'mails.for-submitters.thanks-for-report-bugs-mail',
        );
    }
}
