<?php

namespace App\Mail;

use App\Models\CppPromotion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CppCapacityReachedAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CppPromotion $promotion) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Promotion Full — ' . $this->promotion->title,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.cpp.capacity-reached-alert');
    }
}
