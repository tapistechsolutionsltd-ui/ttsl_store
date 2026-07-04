<?php

namespace App\Mail;

use App\Models\CppClient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CppNewClientAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CppClient $client) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New CPP Registration — ' . ($this->client->activeCode->code ?? $this->client->id),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.cpp.new-client-alert');
    }
}
