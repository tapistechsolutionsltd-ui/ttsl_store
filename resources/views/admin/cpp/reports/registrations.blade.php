@extends('layouts.admin')
@section('title', 'CPP Registrations Report')

@section('content')
<form method="GET" class="card p-4 mb-6 flex flex-wrap items-end gap-3">
    <div>
        <label class="form-label">From</label>
        <input type="date" name="from" value="{{ $from }}" class="input-field py-2 text-sm" />
    </div>
    <div>
        <label class="form-label">To</label>
        <input type="date" name="to" value="{{ $to }}" class="input-field py-2 text-sm" />
    </div>
    <button type="submit" class="btn-primary btn-sm">Filter</button>
    <a href="{{ route('admin.cpp.reports.registrations.download', ['from' => $from, 'to' => $to]) }}" class="btn-secondary btn-sm">Export CSV</a>
    <a href="{{ route('admin.cpp.reports.registrations.pdf', ['from' => $from, 'to' => $to]) }}" class="btn-secondary btn-sm">Export PDF</a>
</form>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Total Registrations</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $clients->count() }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Conversion Rate</p>
        <p class="text-2xl font-bold text-brand mt-1">{{ $conversionRate }}%</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Promotions Represented</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $perPromotion->count() }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Products Represented</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $perProduct->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card p-5">
        <h2 class="font-bold text-gray-800 mb-3">Registrations per Promotion</h2>
        @foreach($perPromotion as $title => $count)
            <div class="flex justify-between text-sm py-1 border-b border-gray-50"><span>{{ $title }}</span><span class="font-semibold">{{ $count }}</span></div>
        @endforeach
    </div>
    <div class="card p-5">
        <h2 class="font-bold text-gray-800 mb-3">Status Breakdown</h2>
        @foreach($statusBreakdown as $status => $count)
            <div class="flex justify-between text-sm py-1 border-b border-gray-50">
                <span>{{ \App\Models\CppClient::TIMELINE_STATUSES[$status] ?? $status }}</span><span class="font-semibold">{{ $count }}</span>
            </div>
        @endforeach
    </div>
</div>

<div class="card overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="table-header">Code</th>
                <th class="table-header">Company</th>
                <th class="table-header">Promotion</th>
                <th class="table-header">Product</th>
                <th class="table-header">Status</th>
                <th class="table-header">Registered</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($clients as $client)
                <tr>
                    <td class="table-cell font-mono text-brand">{{ $client->activeCode->code ?? '—' }}</td>
                    <td class="table-cell">{{ $client->company_name ?? '—' }}</td>
                    <td class="table-cell">{{ $client->promotion->title ?? '—' }}</td>
                    <td class="table-cell">{{ $client->product->name ?? '—' }}</td>
                    <td class="table-cell">{{ $client->current_timeline_label }}</td>
                    <td class="table-cell text-sm text-gray-500">{{ $client->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No registrations in this period</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
