<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Thank you for contacting us — {{ $storeName }}</title>
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
        .check-circle { width: 64px; height: 64px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; text-align: center; line-height: 64px; font-size: 30px; }
        h2 { color: #0a2540; font-size: 22px; font-weight: 700; margin: 0 0 8px; text-align: center; }
        .subtitle { color: #6b7280; font-size: 14px; text-align: center; margin: 0 0 32px; }
        .greeting { color: #111827; font-size: 15px; line-height: 1.7; margin: 0 0 16px; }
        .custom-message { background: #f9fafb; border: 1px solid #e5e7eb; border-left: 4px solid #08a368; border-radius: 0 8px 8px 0; padding: 20px 24px; margin-bottom: 28px; }
        .custom-message p { color: #374151; font-size: 15px; line-height: 1.7; margin: 0; white-space: pre-wrap; }
        .summary-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 20px 24px; margin-bottom: 28px; }
        .summary-box .box-title { color: #065f46; font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin: 0 0 12px; }
        .summary-table { width: 100%; border-collapse: collapse; }
        .summary-table td { padding: 6px 0; font-size: 14px; color: #374151; vertical-align: top; }
        .summary-table .slabel { color: #9ca3af; font-weight: 600; width: 80px; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 28px 0; }
        .cta-section { text-align: center; margin-bottom: 8px; }
        .cta-btn { display: inline-block; background: linear-gradient(90deg, #08a368 0%, #05d68a 100%); color: #ffffff !important; text-decoration: none; font-size: 14px; font-weight: 700; padding: 13px 28px; border-radius: 8px; }
        .cta-subtext { color: #9ca3af; font-size: 12px; margin: 10px 0 0; text-align: center; }
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
                <p class="header-tagline">Customer Support</p>
            </td>
        </tr>
        <tr><td class="accent-bar"></td></tr>

        {{-- Body --}}
        <tr>
            <td class="body-content">

                {{-- Check icon --}}
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                    <tr><td style="text-align:center;padding-bottom:16px;">
                        <div style="display:inline-block;width:64px;height:64px;background:#ecfdf5;border-radius:50%;line-height:64px;font-size:30px;text-align:center;">✅</div>
                    </td></tr>
                </table>

                <h2>Message Received!</h2>
                <p class="subtitle">We've got your enquiry and will be in touch soon.</p>

                <p class="greeting">Hi <strong>{{ $senderName }}</strong>,</p>

                {{-- Custom message from admin --}}
                <div class="custom-message">
                    <p>{{ $autoReplyMessage }}</p>
                </div>

                {{-- Summary of what they sent --}}
                <div class="summary-box">
                    <p class="box-title">Your Enquiry Summary</p>
                    <table class="summary-table" role="presentation" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="slabel">Subject</td>
                            <td>{{ $subject }}</td>
                        </tr>
                        <tr>
                            <td class="slabel">Sent</td>
                            <td>{{ now()->format('d M Y, H:i T') }}</td>
                        </tr>
                        <tr>
                            <td class="slabel">Message</td>
                            <td style="color:#6b7280;white-space:pre-wrap;">{{ $body }}</td>
                        </tr>
                    </table>
                </div>

                <hr class="divider">

                {{-- CTA --}}
                <div class="cta-section">
                    <a href="{{ $storeWebsite }}/shop" class="cta-btn">Browse Our Store</a>
                    <p class="cta-subtext">Or visit <a href="{{ $storeWebsite }}" style="color:#08a368;">{{ $storeWebsite }}</a></p>
                </div>

            </td>
        </tr>

        {{-- Footer --}}
        <tr>
            <td class="footer">
                <div class="footer-logo">@include('emails.partials.logo-sm')</div>
                <p class="footer-address">
                    <strong style="color:#ffffff;">{{ $storeName }}</strong><br>
                    Papua New Guinea<br>
                    @if($storePhone)
                        📞 {{ $storePhone }}&nbsp;&nbsp;
                    @endif
                    @if($storeEmail)
                        ✉ {{ $storeEmail }}
                    @endif
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
                <p class="footer-copy" style="margin-top:8px;">You received this because you submitted our contact form. Please do not reply to this automated message.</p>
            </td>
        </tr>

    </table>
</div>
</body>
</html>
