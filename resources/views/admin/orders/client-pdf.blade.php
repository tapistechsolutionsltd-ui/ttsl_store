<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 9pt;
    color: #222;
    background: #fff;
    line-height: 1.5;
}

/* ─── Watermark ─────────────────────────────────────── */
.watermark {
    position: fixed;
    top: 32%;
    left: -4%;
    font-size: 68pt;
    color: #ececec;
    font-weight: bold;
    transform: rotate(-38deg);
    z-index: -1;
    letter-spacing: 2px;
}

/* ─── Page layout ───────────────────────────────────── */
.page { padding: 30px 36px 20px; }

/* ─── Header ────────────────────────────────────────── */
.header-table       { width: 100%; border-collapse: collapse; }
.logo-cell          { width: 175px; vertical-align: middle; padding-right: 14px; }
.logo-cell img      { width: 155px; height: auto; }
.company-cell       { vertical-align: middle; text-align: right; }
.company-name       { font-size: 10.5pt; font-weight: bold; color: #222; }
.company-sub        { font-size: 7.5pt; color: #555; margin-top: 2px; }

/* ─── Rules ─────────────────────────────────────────── */
.rule      { border: none; border-top: 2px solid #333; margin: 12px 0; }
.rule-thin { border: none; border-top: 1px solid #bbb; margin: 10px 0; }

/* ─── Document title block ──────────────────────────── */
.title-block  { text-align: center; margin: 10px 0 6px; }
.doc-title    { font-size: 15pt; font-weight: bold; color: #222; letter-spacing: 1px; text-transform: uppercase; }
.doc-note     { font-size: 7.5pt; color: #666; font-style: italic; margin-top: 4px; }

/* ─── Meta info ─────────────────────────────────────── */
.meta-table   { width: 100%; border-collapse: collapse; margin: 10px 0 6px; font-size: 8.5pt; }
.meta-table td { padding: 3px 6px; vertical-align: top; }
.meta-label   { font-weight: bold; color: #222; width: 110px; white-space: nowrap; }
.meta-value   { color: #333; }
.meta-label-r { font-weight: bold; color: #222; width: 110px; white-space: nowrap; padding-left: 20px; }

/* ─── Section headings ──────────────────────────────── */
.section-heading {
    font-size: 9.5pt;
    font-weight: bold;
    color: #222;
    margin: 14px 0 5px;
    padding-bottom: 3px;
    border-bottom: 1px solid #bbb;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

/* ─── Address block ─────────────────────────────────── */
.address-name { font-size: 10pt; font-weight: bold; color: #222; }
.address-line { font-size: 8.5pt; color: #444; line-height: 1.7; }

/* ─── Subject / body ────────────────────────────────── */
.subject-line  { margin: 10px 0 8px; font-size: 9pt; }
.subject-label { font-weight: bold; }
.body-para     { font-size: 8.5pt; color: #333; margin: 7px 0; line-height: 1.6; }

/* ─── Detail table ──────────────────────────────────── */
.detail-table { width: 100%; border-collapse: collapse; margin: 6px 0; font-size: 8.5pt; }
.detail-table td { padding: 3px 6px; vertical-align: top; }
.detail-label { font-weight: bold; width: 160px; white-space: nowrap; color: #222; }
.detail-value { color: #333; }

/* ─── Items table ───────────────────────────────────── */
.items-table { width: 100%; border-collapse: collapse; margin: 6px 0; font-size: 8.5pt; }

.items-table thead tr th {
    background: #444;
    color: #fff;
    font-weight: bold;
    padding: 5px 8px;
    text-align: left;
    border: 1px solid #444;
    font-size: 8pt;
}
.items-table thead tr th.tr { text-align: right; }
.items-table thead tr th.tc { text-align: center; }

.items-table tbody tr td {
    padding: 4px 8px;
    border: 1px solid #ddd;
    color: #222;
    vertical-align: top;
}
.items-table tbody tr:nth-child(even) td { background: #f8f8f8; }

.items-table tbody tr.subtotal-row td {
    font-weight: bold;
    border-top: 1px solid #aaa;
    background: #f0f0f0;
    padding: 4px 8px;
}
.items-table tbody tr.total-row td {
    background: #e4e4e4;
    color: #222;
    font-weight: bold;
    font-size: 9pt;
    border: 1px solid #bbb;
    padding: 5px 8px;
}

/* ─── Utility ────────────────────────────────────────── */
.tr   { text-align: right; }
.tc   { text-align: center; }
.bold { font-weight: bold; }

/* ─── Notes box ─────────────────────────────────────── */
.notes-box  { background: #f6f6f6; border: 1px solid #ccc; border-left: 3px solid #888; padding: 8px 12px; margin: 4px 0; }
.notes-text { font-size: 8.5pt; color: #333; line-height: 1.55; }

/* ─── Terms list ────────────────────────────────────── */
.terms-list { margin: 6px 0 0; padding: 0; font-size: 8.5pt; color: #333; }
.terms-list li { margin: 4px 0; list-style: none; padding-left: 0; }

/* ─── Footer ────────────────────────────────────────── */
.footer-bar {
    background: #444;
    color: #fff;
    text-align: center;
    padding: 10px 16px;
    margin-top: 28px;
    font-size: 8pt;
    line-height: 1.8;
}
.footer-sub { font-size: 7pt; color: #bbb; margin-top: 3px; }
</style>
</head>
<body>

@php
    $addr     = $order->shipping_address ?? [];
    $logoPath = public_path('images/Logo.png');
    $logoSrc  = file_exists($logoPath)
                ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
                : '';
@endphp

<div class="watermark">TTSolutions</div>

<div class="page">

    {{-- ── HEADER ── --}}
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" alt="TTSolutions Limited" />
                @else
                    <div class="company-name" style="font-size:14pt;">TTSolutions</div>
                @endif
            </td>
            <td class="company-cell">
                <div class="company-name">TTSolutions Limited (TTSL)</div>
                <div class="company-sub">Papua New Guinea</div>
                <div class="company-sub">+675 7224 3900 &nbsp;&bull;&nbsp; ttsl.support@gmail.com &nbsp;&bull;&nbsp; www.ttsolutionspng.com</div>
            </td>
        </tr>
    </table>

    <hr class="rule" />

    {{-- ── DOCUMENT TITLE ── --}}
    <div class="title-block">
        <div class="doc-title">Client Order Brief</div>
        <div class="doc-note">Official project brief and order record for the services listed below.</div>
    </div>

    <hr class="rule-thin" />

    {{-- ── META INFO ── --}}
    <table class="meta-table">
        <tr>
            <td class="meta-label">Order No:</td>
            <td class="meta-value">{{ $order->order_number }}</td>
            <td class="meta-label-r">Order Date:</td>
            <td class="meta-value">{{ $order->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Project Status:</td>
            <td class="meta-value">{{ $order->status_label }}</td>
            <td class="meta-label-r">Payment:</td>
            <td class="meta-value">{{ ucfirst($order->payment_status) }} &mdash; {{ $order->payment_method_label }}</td>
        </tr>
        @if($order->development_due_date)
        <tr>
            <td class="meta-label">Est. Completion:</td>
            <td class="meta-value">{{ $order->development_due_date->format('d M Y') }}</td>
            <td class="meta-label-r">Prepared By:</td>
            <td class="meta-value">TTSolutions Limited</td>
        </tr>
        @endif
        <tr>
            <td class="meta-label">Generated:</td>
            <td class="meta-value" colspan="3">{{ now()->format('d M Y, H:i T') }}</td>
        </tr>
    </table>

    <hr class="rule-thin" />

    {{-- ── ADDRESSED TO ── --}}
    <div class="section-heading">Addressed To</div>
    <div class="address-name">
        {{ $addr['full_name'] ?? '' }}@if($order->organisation) &nbsp;&mdash;&nbsp; {{ $order->organisation }}@endif
    </div>
    <div class="address-line">
        {{ $addr['address'] ?? '' }}{{ isset($addr['city']) ? ', ' . $addr['city'] : '' }}{{ isset($addr['province']) ? ', ' . $addr['province'] : '' }}, {{ $addr['country'] ?? 'Papua New Guinea' }}
    </div>
    <div class="address-line" style="margin-top:3px;">
        <strong>Phone:</strong> {{ $addr['phone'] ?? '—' }}
        &nbsp;&nbsp;<strong>Email:</strong> {{ $order->client_email ?? ($order->user->email ?? '—') }}
    </div>

    <div class="subject-line" style="margin-top:10px;">
        <span class="subject-label">Re:</span> Client Order Brief &mdash; Order {{ $order->order_number }}
    </div>

    <div class="body-para">Dear {{ $addr['full_name'] ?? 'Client' }},</div>
    <div class="body-para">Thank you for choosing TTSolutions Limited. We are pleased to confirm the following project order. This document serves as the official brief for your web development service.</div>

    {{-- ── PROJECT & TECHNICAL DETAILS ── --}}
    @if($order->website_type || $order->existing_domain || $order->is_first_website !== null || $order->preferred_colors || $order->social_media_links)
    <div class="section-heading">Project &amp; Technical Details</div>
    @if($order->website_type)
    <div class="body-para"><strong>Website Type:</strong> {{ $order->website_type }}</div>
    @endif
    <table class="detail-table">
        <tr>
            <td class="detail-label">First Website?</td>
            <td class="detail-value">
                @if($order->is_first_website === null) Not specified
                @elseif($order->is_first_website) Yes — This is the client's first website
                @else No — Client has an existing website
                @endif
            </td>
        </tr>
        @if($order->existing_domain)
        <tr>
            <td class="detail-label">Existing Domain:</td>
            <td class="detail-value">{{ $order->existing_domain }}</td>
        </tr>
        @endif
        @if($order->preferred_colors)
        <tr>
            <td class="detail-label">Preferred Colours:</td>
            <td class="detail-value">{{ $order->preferred_colors }}</td>
        </tr>
        @endif
        @if($order->social_media_links)
        <tr>
            <td class="detail-label">Social Media:</td>
            <td class="detail-value" style="white-space:pre-line;">{{ $order->social_media_links }}</td>
        </tr>
        @endif
    </table>
    @endif

    {{-- ── SERVICES ORDERED ── --}}
    <div class="section-heading">Services Ordered</div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width:24px;" class="tc">#</th>
                <th>Description / Product</th>
                <th style="width:80px;">SKU</th>
                <th class="tc" style="width:34px;">Qty</th>
                <th class="tr" style="width:78px;">Unit Price</th>
                <th class="tr" style="width:78px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $i => $item)
            <tr>
                <td class="tc">{{ $i + 1 }}</td>
                <td class="bold">
                    {{ $item->product_name }}
                    @if(!empty($item->features))
                        <div style="font-size:7.5pt;color:#888;font-weight:normal;margin-top:2px;">
                            @foreach($item->features as $f)
                                + {{ $f['name'] }} (K {{ number_format($f['price'], 2) }})<br>
                            @endforeach
                        </div>
                    @endif
                </td>
                <td style="font-size:7.5pt;color:#666;">{{ $item->product_sku }}</td>
                <td class="tc">{{ $item->quantity }}</td>
                <td class="tr">K {{ number_format($item->price, 2) }}</td>
                <td class="tr bold">K {{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach

            @if($order->discount > 0)
            <tr class="subtotal-row">
                <td colspan="4"></td>
                <td class="tr">Subtotal</td>
                <td class="tr">K {{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="tr">Discount</td>
                <td class="tr">&minus;K {{ number_format($order->discount, 2) }}</td>
            </tr>
            @else
            <tr class="subtotal-row">
                <td colspan="4"></td>
                <td class="tr">Subtotal</td>
                <td class="tr">K {{ number_format($order->subtotal, 2) }}</td>
            </tr>
            @endif

            <tr class="total-row">
                <td colspan="4"></td>
                <td class="tr">TOTAL</td>
                <td class="tr">K {{ number_format($order->total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @php $halfPayment = $order->total / 2; @endphp
    <div class="body-para" style="margin-top:5px; font-size:8pt; color:#555; font-style:italic;">
        A deposit of K{{ number_format($halfPayment, 2) }} (50%) is required to commence development, with the remaining K{{ number_format($halfPayment, 2) }} due upon project completion.
    </div>

    {{-- ── PROJECT NOTES ── --}}
    @if($order->notes)
    <div class="section-heading">Notes from Client</div>
    <div class="notes-box">
        <div class="notes-text">{{ $order->notes }}</div>
    </div>
    @endif

    {{-- ── TERMS & CONDITIONS ── --}}
    <div class="section-heading">Terms &amp; Conditions</div>
    <ol class="terms-list">
        <li>1. This Client Order Brief is valid upon receipt of the initial deposit payment.</li>
        <li>2. A 50% deposit (K{{ number_format($halfPayment, 2) }}) is required before development commences, with the balance due upon project completion and handover.</li>
        <li>3. Estimated completion is {{ $order->development_due_date ? $order->development_due_date->format('d M Y') : 'subject to agreement' }}, from the date of deposit receipt and content submission.</li>
        <li>4. Content, images, and all required materials must be provided by the client in a timely manner to avoid delays.</li>
        <li>5. Revision requests beyond the agreed scope may attract additional charges.</li>
        <li>6. TTSolutions Limited retains the right to display completed work in its portfolio unless otherwise agreed in writing.</li>
    </ol>

</div>

{{-- ── FOOTER ── --}}
<div class="footer-bar">
    TTSolutions Limited &nbsp;&bull;&nbsp; +675 7224 3900 &nbsp;&bull;&nbsp; ttsl.support@gmail.com &nbsp;&bull;&nbsp; www.ttsolutionspng.com
    <div class="footer-sub">Document generated automatically on {{ now()->format('d M Y \a\t H:i T') }}. Not to be reproduced without authorisation.</div>
</div>

</body>
</html>
