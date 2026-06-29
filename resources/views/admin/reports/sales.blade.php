@extends('layouts.admin')
@section('title', 'Sales Report')

@section('content')
<form method="GET" action="{{ route('admin.reports.sales') }}" class="card p-4 mb-6 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
        <input type="date" name="from" value="{{ $from }}" class="input-field py-2 text-sm" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
        <input type="date" name="to" value="{{ $to }}" class="input-field py-2 text-sm" />
    </div>
    <button type="submit" class="btn-primary btn-sm flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Generate Report
    </button>
    <a href="{{ route('admin.reports.sales.download', ['from' => $from, 'to' => $to]) }}"
       class="btn-secondary btn-sm flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Download CSV
    </a>
    <a href="{{ route('admin.reports.sales.pdf', ['from' => $from, 'to' => $to]) }}"
       class="btn-sm flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg px-3 py-2 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
        Download PDF
    </a>
</form>

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="stat-card text-center">
        <div class="text-2xl font-bold text-green-600">K {{ number_format($totalRevenue, 2) }}</div>
        <div class="text-sm text-gray-500 mt-1">Total Revenue</div>
    </div>
    <div class="stat-card text-center">
        <div class="text-2xl font-bold text-brand">{{ $totalOrders }}</div>
        <div class="text-sm text-gray-500 mt-1">Total Orders</div>
    </div>
    <div class="stat-card text-center">
        <div class="text-2xl font-bold text-purple-600">K {{ number_format($avgOrder, 2) }}</div>
        <div class="text-sm text-gray-500 mt-1">Avg Order Value</div>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="p-5 border-b"><h2 class="font-bold text-gray-800">Orders in Period</h2></div>
    <table class="w-full">
        <thead class="bg-gray-50"><tr>
            <th class="table-header">Order #</th>
            <th class="table-header">Customer</th>
            <th class="table-header">Date</th>
            <th class="table-header">Payment</th>
            <th class="table-header">Total</th>
        </tr></thead>
        <tbody class="divide-y">
            @forelse($orders as $order)
                <tr>
                    <td class="table-cell text-brand font-medium">
                        <a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a>
                    </td>
                    <td class="table-cell">{{ $order->user->name ?? 'N/A' }}</td>
                    <td class="table-cell text-gray-500 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="table-cell"><span class="badge {{ $order->payment_badge_class }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td class="table-cell font-bold text-brand">K {{ number_format($order->total, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-12 text-gray-400">No orders in this period</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
