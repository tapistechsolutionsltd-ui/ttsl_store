<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #111827; }
        h1 { font-size: 16px; color: #0a2540; margin-bottom: 2px; }
        p.meta { color: #6b7280; margin: 0 0 14px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1c3f6e; color: #fff; padding: 6px 8px; text-align: left; }
        td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <h1>TTSolutions Limited — Client Promotions Portal: Registrations Report</h1>
    <p class="meta">Period {{ $from }} to {{ $to }} &middot; Generated {{ now()->format('d M Y H:i') }} &middot; Total {{ $clients->count() }}</p>
    <table>
        <thead>
            <tr>
                <th>Code</th><th>Company</th><th>Promotion</th><th>Product</th><th>Status</th><th>Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->activeCode->code ?? '—' }}</td>
                    <td>{{ $client->company_name ?? '—' }}</td>
                    <td>{{ $client->promotion->title ?? '—' }}</td>
                    <td>{{ $client->product->name ?? '—' }}</td>
                    <td>{{ $client->current_timeline_label }}</td>
                    <td>{{ $client->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
