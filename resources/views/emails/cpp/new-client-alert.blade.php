<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New CPP Registration</title>
    <style>
        body { margin:0; padding:0; background:#f3f4f6; font-family:'Segoe UI',Arial,sans-serif; }
        .wrap { max-width:600px; margin:32px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08); }
        .header { background:linear-gradient(135deg,#0a2540 0%,#0d3b6e 100%); padding:28px; text-align:center; }
        .body { padding:32px; color:#111827; font-size:14px; line-height:1.7; }
        table { width:100%; border-collapse:collapse; margin:16px 0; font-size:13px; }
        td { padding:7px 10px; border-bottom:1px solid #f3f4f6; }
        .label { color:#6b7280; font-weight:600; width:150px; background:#f9fafb; }
        .footer { background:#0a2540; padding:20px; text-align:center; color:#93c5fd; font-size:11px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">@include('emails.partials.logo')</div>
    <div class="body">
        <h2 style="margin-top:0;color:#0a2540;">New Client Promotions Portal Registration</h2>
        <p>A new client has registered for the <strong>{{ $client->promotion->title }}</strong> promotion.</p>
        <table>
            <tr><td class="label">Promotion Code</td><td><strong>{{ $client->activeCode->code ?? 'N/A' }}</strong></td></tr>
            <tr><td class="label">Company</td><td>{{ $client->company_name ?? 'N/A' }}</td></tr>
            <tr><td class="label">Customer</td><td>{{ $client->user->name ?? 'N/A' }} ({{ $client->user->email ?? '' }})</td></tr>
            <tr><td class="label">Product</td><td>{{ $client->product->name ?? 'N/A' }}</td></tr>
            <tr><td class="label">Order</td><td>{{ $client->order->order_number ?? 'N/A' }}</td></tr>
            <tr><td class="label">Registered</td><td>{{ $client->created_at->format('d M Y, H:i') }}</td></tr>
            <tr><td class="label">Remaining Slots</td><td>{{ $client->promotion->remainingSlots() ?? 'Unlimited' }}</td></tr>
        </table>
        <p><a href="{{ route('admin.cpp.clients.show', $client) }}" style="color:#1d4ed8;">View this registration in the Admin Panel</a></p>
    </div>
    <div class="footer">TTSolutions Limited — Client Promotions Portal</div>
</div>
</body>
</html>
