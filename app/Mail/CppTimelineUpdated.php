<?php

namespace App\Mail;

use App\Models\CppClient;
use App\Models\CppTimelineLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CppTimelineUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CppClient $client, public CppTimelineLog $log) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Project Update — ' . $this->client->promotion->title,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.cpp.timeline-updated');
    }
}
