<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        $fromEmail = Setting::get('order_confirmation_from_email', 'ttsl.support@gmail.com');
        $fromName  = Setting::get('order_confirmation_from_name', 'TTSolutions Limited');

        return new Envelope(
            from: new Address($fromEmail, $fromName),
            replyTo: [new Address($fromEmail, $fromName)],
            subject: 'Order Confirmed — ' . $this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.order-confirmation');
    }
}
