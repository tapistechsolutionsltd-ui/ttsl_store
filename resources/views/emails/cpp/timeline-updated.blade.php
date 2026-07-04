<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Update</title>
    <style>
        body { margin:0; padding:0; background:#f3f4f6; font-family:'Segoe UI',Arial,sans-serif; }
        .wrap { max-width:600px; margin:32px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08); }
        .header { background:linear-gradient(135deg,#0a2540 0%,#0d3b6e 100%); padding:28px; text-align:center; }
        .body { padding:32px; color:#111827; font-size:14px; line-height:1.7; }
        .badge { display:inline-block; background:#eff6ff; color:#1d4ed8; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:5px 14px; border-radius:20px; border:1px solid #bfdbfe; margin-bottom:16px; }
        .footer { background:#0a2540; padding:20px; text-align:center; color:#93c5fd; font-size:11px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">@include('emails.partials.logo')</div>
    <div class="body">
        <div class="badge">Project Update</div>
        <h2 style="margin-top:0;color:#0a2540;">Your project status has been updated</h2>
        <p>Hi{{ $client->company_name ? ' ' . $client->company_name : '' }}, your promotion code
            <strong>{{ $client->activeCode->code ?? '' }}</strong> for <strong>{{ $client->promotion->title }}</strong>
            has moved to a new stage:</p>
        <p style="font-size:18px;font-weight:700;color:#1c3f6e;">{{ $log->status_label }}</p>
        @if($log->notes)
            <p style="color:#374151;">{{ $log->notes }}</p>
        @endif
        <p>You can check your project's live progress anytime at
            <a href="{{ route('cpp.show', $client->promotion) }}" style="color:#1d4ed8;">the Client Promotions Portal</a>
            by entering your code.</p>
    </div>
    <div class="footer">TTSolutions Limited — Client Promotions Portal</div>
</div>
</body>
</html>
