@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="page-header"><div class="container mx-auto px-4"><h1 class="text-3xl font-bold">My Orders</h1></div></div>
<div class="container mx-auto px-4 py-8">
    @if($orders->isEmpty())
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-700 mb-4">No projects yet</h2>
            <a href="{{ route('shop') }}" class="btn-primary">Browse Templates</a>
        </div>
    @else
        <div class="card">
            <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="table-header">Order</th>
                        <th class="table-header">Date</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">Payment</th>
                        <th class="table-header">Total</th>
                        <th class="table-header">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell font-medium text-brand">{{ $order->order_number }}</td>
                            <td class="table-cell text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="table-cell"><span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span></td>
                            <td class="table-cell"><span class="badge {{ $order->payment_badge_class }}">{{ ucfirst($order->payment_status) }}</span></td>
                            <td class="table-cell font-bold text-brand">K {{ number_format($order->total, 2) }}</td>
                            <td class="table-cell"><a href="{{ route('account.order.detail', $order) }}" class="text-brand hover:underline text-sm">View →</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
