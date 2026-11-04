<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** A short confirmation to the person who submitted a form. */
class Receipt extends Mailable
{
    use Queueable, SerializesModels;

    /** @param list<string> $paragraphs */
    public function __construct(public string $subjectLine, public array $paragraphs) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subjectLine);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.receipt');
    }
}
