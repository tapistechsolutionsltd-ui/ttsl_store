@extends('layouts.admin')
@section('title', 'Customer Report')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h2 class="font-bold text-gray-800 text-lg">Customer Report</h2>
    <a href="{{ route('admin.reports.customers.download') }}"
       class="btn-primary btn-sm flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Download CSV
    </a>
</div>
<div class="card overflow-hidden">
    <div class="p-5 border-b"><h2 class="font-bold text-gray-800">Top Customers by Spending</h2></div>
    <table class="w-full">
        <thead class="bg-gray-50"><tr>
            <th class="table-header">#</th>
            <th class="table-header">Customer</th>
            <th class="table-header">Total Orders</th>
            <th class="table-header">Total Spent</th>
            <th class="table-header">Joined</th>
        </tr></thead>
        <tbody class="divide-y">
            @forelse($customers as $i => $c)
                <tr>
                    <td class="table-cell text-gray-400">{{ $customers->firstItem() + $i }}</td>
                    <td class="table-cell">
                        <a href="{{ route('admin.customers.show', $c) }}" class="font-medium text-brand hover:underline">{{ $c->name }}</a>
                        <p class="text-xs text-gray-400">{{ $c->email }}</p>
                    </td>
                    <td class="table-cell font-semibold">{{ $c->orders_count }}</td>
                    <td class="table-cell font-bold text-green-600">K {{ number_format($c->orders_sum_total ?? 0, 2) }}</td>
                    <td class="table-cell text-gray-400 text-sm">{{ $c->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-12 text-gray-400">No data</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $customers->links() }}</div>
</div>
@endsection
