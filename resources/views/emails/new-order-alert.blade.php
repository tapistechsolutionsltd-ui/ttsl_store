<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Order Received — {{ $order->order_number }}</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Segoe UI', Arial, sans-serif; }
        .email-wrapper { width: 100%; background-color: #f3f4f6; padding: 32px 0; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0a2540 0%, #0d3b6e 100%); padding: 32px 40px; text-align: center; }
        .header-tagline { color: #93c5fd; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; margin: 0; }
        .accent-bar { height: 4px; background: linear-gradient(90deg, #f59e0b 0%, #ef4444 100%); }
        .body-content { padding: 40px; }
        .badge { display: inline-block; background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 14px; border-radius: 20px; border: 1px solid #fde68a; margin-bottom: 20px; }
        h2 { color: #0a2540; font-size: 22px; font-weight: 700; margin: 0 0 8px; }
        .subtitle { color: #6b7280; font-size: 14px; margin: 0 0 24px; line-height: 1.6; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px; }
        .info-table td { padding: 8px 12px; border-bottom: 1px solid #f3f4f6; }
        .info-table .label { color: #6b7280; font-weight: 600; width: 140px; background: #f9fafb; white-space: nowrap; }
        .info-table .value { color: #111827; }
        .section-title { font-size: 13px; font-weight: 700; color: #0a2540; letter-spacing: 0.5px; text-transform: uppercase; margin: 24px 0 10px; border-bottom: 2px solid #e5e7eb; padding-bottom: 6px; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px; }
        .items-table th { background: #1c3f6e; color: #fff; padding: 8px 12px; text-align: left; font-size: 12px; }
        .items-table th.tr { text-align: right; }
        .items-table td { padding: 8px 12px; border-bottom: 1px solid #f3f4f6; color: #374151; }
        .items-table .total-row td { background: #1c3f6e; color: #fff; font-weight: 700; border: none; }
        .tr { text-align: right; }
        .highlight-box { background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #3b82f6; border-radius: 0 8px 8px 0; padding: 16px 20px; margin-bottom: 20px; font-size: 13px; color: #374151; line-height: 1.7; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 24px 0; }
        .footer { background: #0a2540; padding: 24px 40px; text-align: center; }
        .footer-info { color: #93c5fd; font-size: 12px; line-height: 1.8; margin: 0 0 10px; }
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
                <p class="header-tagline">Admin Notification</p>
            </td>
        </tr>
        <tr><td class="accent-bar"></td></tr>

        {{-- Body --}}
        <tr>
            <td class="body-content">
                <div class="badge">New Order</div>
                <h2>A new order has been placed</h2>
                <p class="subtitle">
                    Order <strong>{{ $order->order_number }}</strong> was submitted on
                    {{ $order->created_at->format('l, d F Y') }} at {{ $order->created_at->format('H:i T') }}.
                    Please review the details below and follow up with the client.
                </p>

                {{-- Order summary --}}
                <div class="section-title">Order Summary</div>
                <table class="info-table">
                    <tr><td class="label">Order Number</td><td class="value"><strong>{{ $order->order_number }}</strong></td></tr>
                    <tr><td class="label">Date &amp; Time</td><td class="value">{{ $order->created_at->format('d M Y, H:i T') }}</td></tr>
                    <tr><td class="label">Total Amount</td><td class="value"><strong style="color:#1c3f6e;">K {{ number_format($order->total, 2) }}</strong></td></tr>
                    <tr><td class="label">50% Deposit Due</td><td class="value"><strong>K {{ number_format($order->total * 0.5, 2) }}</strong></td></tr>
                    <tr><td class="label">Payment Method</td><td class="value">{{ $order->payment_method === 'bank_transfer' ? 'Bank Transfer' : 'Cash on Completion' }}</td></tr>
                    <tr><td class="label">Payment Status</td><td class="value">{{ ucfirst($order->payment_status) }}</td></tr>
                    <tr><td class="label">Order Status</td><td class="value">{{ ucfirst($order->order_status) }}</td></tr>
                </table>

                {{-- Client info --}}
                <div class="section-title">Client Information</div>
                <table class="info-table">
                    @php $addr = (array) ($order->shipping_address ?? []); @endphp
                    <tr><td class="label">Full Name</td><td class="value">{{ $addr['full_name'] ?? $order->user->name ?? 'N/A' }}</td></tr>
                    <tr><td class="label">Email</td><td class="value"><a href="mailto:{{ $order->client_email }}" style="color:#1c3f6e;">{{ $order->client_email }}</a></td></tr>
                    <tr><td class="label">Phone</td><td class="value">{{ $addr['phone'] ?? 'N/A' }}</td></tr>
                    @if($order->organisation)
                    <tr><td class="label">Organisation</td><td class="value">{{ $order->organisation }}</td></tr>
                    @endif
                    <tr><td class="label">Location</td><td class="value">{{ $addr['city'] ?? '' }}{{ isset($addr['province']) ? ', ' . $addr['province'] : '' }}</td></tr>
                    @if($order->website_type)
                    <tr><td class="label">Website Type</td><td class="value">{{ $order->website_type }}</td></tr>
                    @endif
                    @if($order->is_first_website !== null)
                    <tr><td class="label">First Website?</td><td class="value">{{ $order->is_first_website ? 'Yes' : 'No' }}</td></tr>
                    @endif
                    @if($order->existing_domain)
                    <tr><td class="label">Existing Domain</td><td class="value">{{ $order->existing_domain }}</td></tr>
                    @endif
                </table>

                {{-- Items --}}
                <div class="section-title">Items Ordered</div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Service / Product</th>
                            <th class="tr">Qty</th>
                            <th class="tr">Total (K)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                {{ $item->product_name }}
                                @if(!empty($item->features))
                                    @foreach($item->features as $f)
                                        <br><span style="font-size:11px;color:#9ca3af;">+ {{ $f['name'] }} (K {{ number_format($f['price'], 2) }})</span>
                                    @endforeach
                                @endif
                            </td>
                            <td class="tr">{{ $item->quantity }}</td>
                            <td class="tr">K {{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="2" style="text-align:right;">TOTAL</td>
                            <td class="tr">K {{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                {{-- Admin panel note --}}
                <div class="highlight-box">
                    <strong>Action Required:</strong> Log in to the Admin Panel to review this order, update the project status, and follow up with the client regarding their deposit payment and project brief.
                    <br><br>
                    <strong>Admin Panel:</strong> <a href="{{ route('admin.orders.show', $order->id) }}" style="color:#1d4ed8;">View Order #{{ $order->order_number }}</a>
                </div>

                <hr class="divider">
                <p style="font-size:12px;color:#9ca3af;margin:0;">This is an automated notification. Do not reply to this email directly.</p>
            </td>
        </tr>

        {{-- Footer --}}
        <tr>
            <td class="footer">
                <p class="footer-info">
                    <strong style="color:#ffffff;">TTSolutions Limited — Admin System</strong><br>
                    ttsl.support@gmail.com &nbsp;|&nbsp; <a href="https://www.ttsolutionspng.com" style="color:#93c5fd;text-decoration:none;">www.ttsolutionspng.com</a>
                </p>
                <p class="footer-copy">&copy; {{ date('Y') }} TTSolutions Limited. All rights reserved.</p>
            </td>
        </tr>

    </table>
</div>
</body>
</html>
