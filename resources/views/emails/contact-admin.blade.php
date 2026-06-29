<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Contact Message — {{ $storeName }}</title>
    <!--[if mso]>
    <noscript>
        <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
    </noscript>
    <![endif]-->
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Segoe UI', Arial, sans-serif; }
        .email-wrapper { width: 100%; background-color: #f3f4f6; padding: 32px 0; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0a2540 0%, #0d3b6e 100%); padding: 32px 40px; text-align: center; }
        .header-tagline { color: #93c5fd; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; margin: 0; }
        .accent-bar { height: 4px; background: linear-gradient(90deg, #08a368 0%, #05d68a 100%); }
        .body-content { padding: 40px; }
        .badge { display: inline-block; background: #ecfdf5; color: #065f46; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 14px; border-radius: 20px; border: 1px solid #a7f3d0; margin-bottom: 20px; }
        h2 { color: #0a2540; font-size: 22px; font-weight: 700; margin: 0 0 8px; }
        .subtitle { color: #6b7280; font-size: 14px; margin: 0 0 28px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 28px; }
        .info-table td { padding: 10px 14px; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
        .info-table tr:last-child td { border-bottom: none; }
        .info-table .label { color: #9ca3af; font-weight: 600; white-space: nowrap; width: 90px; background-color: #f9fafb; border-radius: 4px; }
        .info-table .value { color: #111827; }
        .info-table .value a { color: #08a368; text-decoration: none; }
        .message-box { background: #f9fafb; border: 1px solid #e5e7eb; border-left: 4px solid #08a368; border-radius: 0 8px 8px 0; padding: 20px 24px; margin-bottom: 28px; }
        .message-box .msg-label { color: #9ca3af; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin: 0 0 10px; }
        .message-box p { color: #374151; font-size: 15px; line-height: 1.7; margin: 0; white-space: pre-wrap; word-break: break-word; }
        .cta-btn { display: inline-block; background: linear-gradient(90deg, #08a368 0%, #05d68a 100%); color: #ffffff !important; text-decoration: none; font-size: 14px; font-weight: 700; padding: 13px 28px; border-radius: 8px; letter-spacing: 0.3px; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 28px 0; }
        .meta-note { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 18px; margin-top: 24px; }
        .meta-note p { color: #92400e; font-size: 12px; margin: 0; line-height: 1.6; }
        .footer { background: #0a2540; padding: 28px 40px; text-align: center; }
        .footer-logo { margin-bottom: 16px; }
        .footer-address { color: #93c5fd; font-size: 12px; line-height: 1.8; margin: 0 0 14px; }
        .footer-links { margin: 0 0 16px; }
        .footer-links a { color: #60a5fa; font-size: 12px; text-decoration: none; margin: 0 8px; }
        .footer-divider { border: none; border-top: 1px solid #1e3a5f; margin: 16px 0; }
        .footer-copy { color: #475569; font-size: 11px; margin: 0; }
        @media only screen and (max-width: 620px) {
            .email-wrapper { padding: 16px 0; }
            .body-content, .header, .footer { padding: 24px 20px !important; }
            .info-table .label { width: 80px; }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <table class="email-container" role="presentation" cellpadding="0" cellspacing="0" width="100%">

        {{-- Header --}}
        <tr>
            <td class="header">
                @include('emails.partials.logo')
                <p class="header-tagline">Admin Notification</p>
            </td>
        </tr>
        <tr><td class="accent-bar"></td></tr>

        {{-- Body --}}
        <tr>
            <td class="body-content">
                <div class="badge">New Message</div>
                <h2>You have a new contact enquiry</h2>
                <p class="subtitle">A visitor submitted the contact form on {{ now()->format('l, d F Y') }} at {{ now()->format('H:i T') }}.</p>

                {{-- Sender info --}}
                <table class="info-table" role="presentation" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="label">From</td>
                        <td class="value"><strong>{{ $senderName }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="value"><a href="mailto:{{ $senderEmail }}">{{ $senderEmail }}</a></td>
                    </tr>
                    <tr>
                        <td class="label">Subject</td>
                        <td class="value">{{ $subject }}</td>
                    </tr>
                </table>

                {{-- Message body --}}
                <div class="message-box">
                    <p class="msg-label">Message</p>
                    <p>{{ $body }}</p>
                </div>

                {{-- Reply CTA --}}
                <p style="margin:0 0 16px;color:#374151;font-size:14px;">Reply directly to this enquiry:</p>
                <a href="mailto:{{ $senderEmail }}?subject=Re: {{ rawurlencode($subject) }}" class="cta-btn">Reply to {{ $senderName }}</a>

                <hr class="divider">

                {{-- Meta note --}}
                <div class="meta-note">
                    <p>
                        <strong>Note:</strong> This message was sent via the contact form at
                        <a href="{{ $storeWebsite }}" style="color:#92400e;">{{ $storeWebsite }}</a>.
                        Reply-to is set to the sender's address — hit Reply in your email client to respond directly.
                    </p>
                </div>
            </td>
        </tr>

        {{-- Footer --}}
        <tr>
            <td class="footer">
                <div class="footer-logo">
                    @include('emails.partials.logo-sm')
                </div>
                <p class="footer-address">
                    <strong style="color:#ffffff;">{{ $storeName }}</strong><br>
                    Papua New Guinea<br>
                    @if($storePhone)
                        📞 {{ $storePhone }}&nbsp;&nbsp;
                    @endif
                    ✉ ttsl.support@gmail.com
                </p>
                <div class="footer-links">
                    <a href="{{ $storeWebsite }}">Website</a>
                    <span style="color:#1e3a5f;">|</span>
                    <a href="{{ $storeWebsite }}/contact">Contact</a>
                    <span style="color:#1e3a5f;">|</span>
                    <a href="{{ $storeWebsite }}/shop">Shop</a>
                </div>
                <hr class="footer-divider">
                <p class="footer-copy">&copy; {{ date('Y') }} {{ $storeName }}. All rights reserved. &mdash; Papua New Guinea</p>
            </td>
        </tr>

    </table>
</div>
</body>
</html>
