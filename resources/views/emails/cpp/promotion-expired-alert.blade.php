<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Promotion Expired</title>
    <style>
        body { margin:0; padding:0; background:#f3f4f6; font-family:'Segoe UI',Arial,sans-serif; }
        .wrap { max-width:600px; margin:32px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08); }
        .header { background:linear-gradient(135deg,#0a2540 0%,#0d3b6e 100%); padding:28px; text-align:center; }
        .body { padding:32px; color:#111827; font-size:14px; line-height:1.7; }
        .footer { background:#0a2540; padding:20px; text-align:center; color:#93c5fd; font-size:11px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">@include('emails.partials.logo')</div>
    <div class="body">
        <h2 style="margin-top:0;color:#0a2540;">Promotion Expired</h2>
        <p>The promotion <strong>{{ $promotion->title }}</strong> has passed its expiry date
            ({{ $promotion->expiry_date?->format('d M Y, H:i') }}) and has been automatically marked as expired.
            It registered {{ $promotion->registeredCount() }} client(s) in total.</p>
        <p><a href="{{ route('admin.cpp.promotions.edit', $promotion) }}" style="color:#1d4ed8;">Manage this promotion in the Admin Panel</a></p>
    </div>
    <div class="footer">TTSolutions Limited — Client Promotions Portal</div>
</div>
</body>
</html>
