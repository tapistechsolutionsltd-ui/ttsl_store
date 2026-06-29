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
.header-table      { width: 100%; border-collapse: collapse; }
.logo-cell         { width: 175px; vertical-align: middle; padding-right: 14px; }
.logo-cell img     { width: 155px; height: auto; }
.company-cell      { vertical-align: middle; text-align: right; }
.company-name      { font-size: 10.5pt; font-weight: bold; color: #222; }
.company-sub       { font-size: 7.5pt; color: #555; margin-top: 2px; }

/* ─── Rules ─────────────────────────────────────────── */
.rule      { border: none; border-top: 2px solid #333; margin: 12px 0; }
.rule-thin { border: none; border-top: 1px solid #bbb; margin: 10px 0; }

/* ─── Document title ────────────────────────────────── */
.title-block  { text-align: center; margin: 10px 0 6px; }
.doc-title    { font-size: 15pt; font-weight: bold; color: #222; letter-spacing: 1px; text-transform: uppercase; }
.doc-subtitle { font-size: 7.5pt; color: #666; font-style: italic; margin-top: 4px; }

/* ─── Meta table ────────────────────────────────────── */
.meta-table   { width: 100%; border-collapse: collapse; margin: 10px 0 6px; font-size: 8.5pt; }
.meta-table td { padding: 3px 6px; vertical-align: top; }
.meta-label   { font-weight: bold; color: #222; width: 100px; white-space: nowrap; }
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

/* ─── Summary cards ─────────────────────────────────── */
.summary-table { width: 100%; border-collapse: separate; border-spacing: 6px; margin: 6px 0 10px; }
.summary-card  {
    background: #f6f6f6;
    border: 1px solid #d5d5d5;
    border-top: 2px solid #555;
    padding: 8px 12px;
    text-align: center;
}
.card-value { font-size: 12pt; font-weight: bold; color: #222; }
.card-label { font-size: 7.5pt; color: #666; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.4px; }

/* ─── Data tables ───────────────────────────────────── */
.data-table { width: 100%; border-collapse: collapse; margin: 4px 0 12px; font-size: 8.5pt; }

.data-table thead tr th {
    background: #444;
    color: #fff;
    font-weight: bold;
    padding: 5px 8px;
    text-align: left;
    border: 1px solid #444;
    font-size: 8pt;
}
.data-table thead tr th.tr { text-align: right; }
.data-table thead tr th.tc { text-align: center; }

.data-table tbody tr td {
    padding: 4px 8px;
    border: 1px solid #ddd;
    vertical-align: top;
    color: #222;
}
.data-table tbody tr:nth-child(even) td { background: #f8f8f8; }

.data-table tbody tr.total-row td {
    background: #e4e4e4;
    color: #222;
    font-weight: bold;
    font-size: 9pt;
    border: 1px solid #bbb;
    padding: 5px 8px;
}
.data-table tbody tr.subtotal-row td {
    font-weight: bold;
    border-top: 1px solid #aaa;
    background: #f0f0f0;
    padding: 4px 8px;
}

/* ─── Utility ────────────────────────────────────────── */
.tr   { text-align: right; }
.tc   { text-align: center; }
.bold { font-weight: bold; }
.no-data { text-align: center; color: #888; padding: 14px; font-style: italic; font-size: 8.5pt; }

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
        <div class="doc-title">Sales Report</div>
        <div class="doc-subtitle">Confidential &mdash; For authorised personnel only.</div>
    </div>

    <hr class="rule-thin" />

    {{-- ── META INFO ── --}}
    <table class="meta-table">
        <tr>
            <td class="meta-label">Report Period:</td>
            <td class="meta-value">{{ \Carbon\Carbon::parse($from)->format('d M Y') }} &mdash; {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</td>
            <td class="meta-label-r">Generated:</td>
            <td class="meta-value">{{ now()->format('d M Y, H:i T') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Prepared By:</td>
            <td class="meta-value">TTSolutions Limited &mdash; Admin System</td>
            <td class="meta-label-r">Total Orders:</td>
            <td class="meta-value bold">{{ $totalOrders }}</td>
        </tr>
    </table>

    <hr class="rule-thin" />

    {{-- ── SUMMARY ── --}}
    <div class="section-heading">Summary</div>

    <table class="summary-table">
        <tr>
            <td class="summary-card">
                <div class="card-value">K {{ number_format($totalRevenue, 2) }}</div>
                <div class="card-label">Total Revenue</div>
            </td>
            <td class="summary-card">
                <div class="card-value">{{ $totalOrders }}</div>
                <div class="card-label">Total Orders (Paid)</div>
            </td>
            <td class="summary-card">
                <div class="card-value">K {{ number_format($avgOrder, 2) }}</div>
                <div class="card-label">Average Order Value</div>
            </td>
        </tr>
    </table>

    {{-- ── DAILY BREAKDOWN ── --}}
    @if($dailySales->isNotEmpty())
    <div class="section-heading">Daily Sales Breakdown</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th class="tc">Orders</th>
                <th class="tr">Revenue (K)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailySales as $date => $dayOrders)
            <tr>
                <td>{{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</td>
                <td class="tc bold">{{ $dayOrders->count() }}</td>
                <td class="tr bold">K {{ number_format($dayOrders->sum('total'), 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td class="bold">TOTAL</td>
                <td class="tc bold">{{ $totalOrders }}</td>
                <td class="tr bold">K {{ number_format($totalRevenue, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @endif

    {{-- ── ORDER DETAILS ── --}}
    <div class="section-heading">Order Details</div>

    @if($orders->isEmpty())
        <p class="no-data">No paid orders found for this period.</p>
    @else
    <table class="data-table">
        <thead>
            <tr>
                <th class="tc" style="width:24px;">#</th>
                <th>Order Number</th>
                <th>Customer</th>
                <th>Date</th>
                <th class="tc" style="width:36px;">Items</th>
                <th class="tc" style="width:66px;">Payment</th>
                <th class="tr" style="width:78px;">Total (K)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $i => $order)
            <tr>
                <td class="tc" style="color:#888;font-size:8pt;">{{ $i + 1 }}</td>
                <td class="bold">{{ $order->order_number }}</td>
                <td>
                    {{ $order->user->name ?? 'Guest' }}
                    @if($order->user)
                    <br><span style="font-size:7.5pt;color:#777;">{{ $order->user->email }}</span>
                    @endif
                </td>
                <td style="white-space:nowrap;">
                    {{ $order->created_at->format('d M Y') }}<br>
                    <span style="font-size:7.5pt;color:#777;">{{ $order->created_at->format('H:i') }}</span>
                </td>
                <td class="tc">{{ $order->items->count() }}</td>
                <td class="tc" style="font-size:8pt;font-weight:bold;">{{ ucfirst($order->payment_status) }}</td>
                <td class="tr bold">K {{ number_format($order->total, 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5"></td>
                <td class="tr bold">TOTAL REVENUE</td>
                <td class="tr bold">K {{ number_format($totalRevenue, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @endif

</div>

{{-- ── FOOTER ── --}}
<div class="footer-bar">
    TTSolutions Limited &nbsp;&bull;&nbsp; +675 7224 3900 &nbsp;&bull;&nbsp; ttsl.support@gmail.com &nbsp;&bull;&nbsp; www.ttsolutionspng.com
    <div class="footer-sub">Document generated automatically on {{ now()->format('d M Y \a\t H:i T') }}. Not to be reproduced without authorisation.</div>
</div>

</body>
</html>
