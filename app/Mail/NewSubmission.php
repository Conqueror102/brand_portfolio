<?php

namespace App\Mail;

use App\Models\Enquiry;
use App\Models\MentorshipApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Alerts the team that a new enquiry or application is waiting in the admin. */
class NewSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $kind, public Enquiry|MentorshipApplication $record) {}

    public function envelope(): Envelope
    {
        $subject = $this->kind === 'application'
            ? 'New mentorship application: '.$this->record->name
            : 'New enquiry: '.$this->record->name.' ('.$this->record->typeLabel().')';

        return new Envelope(subject: $subject, replyTo: [$this->record->email]);
    }

    public function content(): Content
    {
        $link = $this->kind === 'application'
            ? route('admin.applications.show', $this->record)
            : route('admin.enquiries.show', $this->record);

        $lines = $this->kind === 'application'
            ? ['Name' => $this->record->name, 'Email' => $this->record->email, 'Role' => $this->record->role, 'Location' => $this->record->location, 'Goals' => $this->record->goals]
            : ['Name' => $this->record->name, 'Email' => $this->record->email, 'Organisation' => $this->record->organisation, 'Request' => $this->record->typeLabel(), 'Proposed date' => $this->record->proposed_date, 'Message' => $this->record->message];

        return new Content(view: 'mail.submission', with: [
            'heading' => $this->kind === 'application' ? 'A new mentorship application' : 'A new enquiry',
            'lines' => array_filter($lines),
            'link' => $link,
        ]);
    }
}
