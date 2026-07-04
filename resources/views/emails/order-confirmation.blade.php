<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Order Confirmed — {{ $order->order_number }}</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Segoe UI', Arial, sans-serif; }
        .email-wrapper { width: 100%; background-color: #f3f4f6; padding: 32px 0; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0a2540 0%, #0d3b6e 100%); padding: 32px 40px; text-align: center; }
        .header-tagline { color: #93c5fd; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; margin: 0; }
        .accent-bar { height: 4px; background: linear-gradient(90deg, #1c3f6e 0%, #3b82f6 100%); }
        .body-content { padding: 40px; }
        .badge { display: inline-block; background: #eff6ff; color: #1d4ed8; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 14px; border-radius: 20px; border: 1px solid #bfdbfe; margin-bottom: 20px; }
        h2 { color: #0a2540; font-size: 22px; font-weight: 700; margin: 0 0 8px; }
        .subtitle { color: #6b7280; font-size: 14px; margin: 0 0 28px; line-height: 1.6; }
        .order-meta { background: #f8faff; border: 1px solid #e0e7ff; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px; }
        .order-meta table { width: 100%; border-collapse: collapse; }
        .order-meta td { padding: 5px 0; font-size: 13px; }
        .order-meta .label { color: #6b7280; width: 140px; }
        .order-meta .value { color: #111827; font-weight: 600; }
        .section-title { font-size: 13px; font-weight: 700; color: #0a2540; letter-spacing: 0.5px; text-transform: uppercase; margin: 24px 0 12px; border-bottom: 2px solid #e5e7eb; padding-bottom: 6px; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px; }
        .items-table th { background: #1c3f6e; color: #fff; padding: 9px 12px; text-align: left; font-weight: 600; font-size: 12px; }
        .items-table th.tr { text-align: right; }
        .items-table td { padding: 9px 12px; border-bottom: 1px solid #f3f4f6; color: #374151; vertical-align: top; }
        .items-table tr:nth-child(even) td { background: #f8faff; }
        .items-table .total-row td { background: #1c3f6e; color: #fff; font-weight: 700; border-bottom: none; }
        .tr { text-align: right; }
        .payment-box { background: #fffbeb; border: 1px solid #fde68a; border-left: 4px solid #f59e0b; border-radius: 0 8px 8px 0; padding: 18px 22px; margin-bottom: 24px; }
        .payment-box h4 { color: #92400e; font-size: 13px; font-weight: 700; margin: 0 0 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .payment-box table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .payment-box td { padding: 4px 0; color: #374151; }
        .payment-box .plabel { color: #6b7280; width: 130px; }
        .payment-box .note { font-size: 12px; color: #92400e; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #fde68a; line-height: 1.6; }
        .next-steps { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 18px 22px; margin-bottom: 24px; }
        .next-steps h4 { color: #065f46; font-size: 13px; font-weight: 700; margin: 0 0 10px; }
        .next-steps ol { margin: 0; padding-left: 20px; color: #374151; font-size: 13px; line-height: 1.8; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 24px 0; }
        .footer { background: #0a2540; padding: 28px 40px; text-align: center; }
        .footer-info { color: #93c5fd; font-size: 12px; line-height: 1.8; margin: 0 0 14px; }
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
                <p class="header-tagline">Order Confirmation</p>
            </td>
        </tr>
        <tr><td class="accent-bar"></td></tr>

        {{-- Body --}}
        <tr>
            <td class="body-content">
                <div class="badge">Order Confirmed</div>
                <h2>Thank you for your order, {{ $order->shipping_address['full_name'] ?? $order->user->name ?? 'Valued Client' }}!</h2>
                <p class="subtitle">
                    Your order <strong>{{ $order->order_number }}</strong> has been successfully received and is currently under review.
                    Our team will contact you within 1–2 business days to confirm the project brief and initiate commencement.
                </p>

                {{-- Order meta --}}
                <div class="order-meta">
                    <table>
                        <tr>
                            <td class="label">Order Number</td>
                            <td class="value">{{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <td class="label">Order Date</td>
                            <td class="value">{{ $order->created_at->format('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Payment Method</td>
                            <td class="value">{{ $order->payment_method === 'bank_transfer' ? 'Bank Transfer' : 'Cash on Completion' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Payment Status</td>
                            <td class="value">{{ ucfirst($order->payment_status) }}</td>
                        </tr>
                        @if($order->development_due_date)
                        <tr>
                            <td class="label">Est. Completion</td>
                            <td class="value">{{ \Carbon\Carbon::parse($order->development_due_date)->format('d F Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                {{-- Items --}}
                <div class="section-title">Services Ordered</div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Service / Product</th>
                            <th class="tr">Qty</th>
                            <th class="tr">Amount (K)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->product_name }}</strong>
                                @if($item->product && $item->product->sku)
                                    <br><span style="font-size:11px;color:#9ca3af;">SKU: {{ $item->product_sku }}</span>
                                @endif
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
                        @if($order->discount > 0)
                        <tr>
                            <td colspan="2" style="color:#059669;text-align:right;">Coupon Discount</td>
                            <td class="tr" style="color:#059669;">−K {{ number_format($order->discount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="total-row">
                            <td colspan="2" style="text-align:right;">TOTAL</td>
                            <td class="tr">K {{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                {{-- Promotion Code(s) --}}
                @if($order->cppClients->isNotEmpty())
                <div class="next-steps" style="background:#eff6ff;border-color:#bfdbfe;">
                    <h4 style="color:#1d4ed8;">🎉 You Qualify for Our Client Promotions Portal!</h4>
                    @foreach($order->cppClients as $cppClient)
                        <p style="margin:0 0 10px;font-size:13px;color:#374151;">
                            <strong>{{ $cppClient->promotion->title }}</strong><br>
                            Promotion Code: <strong style="letter-spacing:1px;">{{ $cppClient->activeCode->code ?? 'Generating...' }}</strong><br>
                            Keep this code safe — use it at
                            <a href="{{ route('cpp.show', $cppClient->promotion) }}" style="color:#1d4ed8;">the Client Promotions Portal</a>
                            to track your project's progress.
                        </p>
                    @endforeach
                </div>
                @endif

                {{-- Payment Instructions --}}
                @if($order->payment_method === 'bank_transfer')
                <div class="payment-box">
                    <h4>Payment Instructions</h4>
                    <table>
                        <tr><td class="plabel">Account Name</td><td><strong>Jimmy Tapis</strong></td></tr>
                        <tr><td class="plabel">BSP Waigani</td><td><strong>7025374278</strong></td></tr>
                        <tr><td class="plabel">Kina Vision City</td><td><strong>32604018</strong></td></tr>
                        <tr><td class="plabel">Deposit Amount</td><td><strong>K {{ number_format($order->total * 0.5, 2) }}</strong> (50% of total)</td></tr>
                        <tr><td class="plabel">Reference</td><td><strong>{{ $order->order_number }}</strong></td></tr>
                    </table>
                    <p class="note">
                        A 50% deposit is required before your project can commence. Please transfer the deposit amount and use your order number as the reference. Send your payment receipt to <a href="mailto:ttsl.support@gmail.com" style="color:#92400e;">ttsl.support@gmail.com</a> to expedite confirmation.
                    </p>
                </div>
                @endif

                {{-- Next Steps --}}
                <div class="next-steps">
                    <h4>What Happens Next?</h4>
                    <ol>
                        <li>Our team will review your order and attached project files.</li>
                        <li>We will contact you to confirm the project scope and timeline.</li>
                        <li>Upon receipt of your deposit, work will commence immediately.</li>
                        <li>You will receive progress updates throughout the development process.</li>
                        <li>Final delivery and handover will be scheduled upon project completion.</li>
                    </ol>
                </div>

                <hr class="divider">
                <p style="font-size:13px;color:#374151;margin:0;">
                    Questions? Contact us at <a href="mailto:ttsl.support@gmail.com" style="color:#1c3f6e;">ttsl.support@gmail.com</a>
                    or call <a href="tel:+67572243900" style="color:#1c3f6e;">+675 7224 3900</a>.
                </p>
            </td>
        </tr>

        {{-- Footer --}}
        <tr>
            <td class="footer">
                <p class="footer-info">
                    <strong style="color:#ffffff;">TTSolutions Limited (TTSL)</strong><br>
                    Papua New Guinea<br>
                    📞 +675 7224 3900 &nbsp;&nbsp; ✉ ttsl.support@gmail.com<br>
                    🌐 <a href="https://www.ttsolutionspng.com" style="color:#93c5fd;text-decoration:none;">www.ttsolutionspng.com</a>
                </p>
                <div class="footer-links">
                    <a href="{{ url('/') }}">Website</a>
                    <span style="color:#1e3a5f;">|</span>
                    <a href="{{ route('contact') }}">Contact</a>
                    <span style="color:#1e3a5f;">|</span>
                    <a href="{{ route('account.orders') }}">My Orders</a>
                </div>
                <hr class="footer-divider">
                <p class="footer-copy">&copy; {{ date('Y') }} TTSolutions Limited. All rights reserved. &mdash; Papua New Guinea</p>
            </td>
        </tr>

    </table>
</div>
</body>
</html>
