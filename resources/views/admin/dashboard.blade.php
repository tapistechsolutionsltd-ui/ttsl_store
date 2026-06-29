@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- Stats Row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">K {{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Orders</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalOrders) }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Customers</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalCustomers) }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Active Products</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalProducts) }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Recent Orders --}}
    <div class="lg:col-span-2 card">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-brand hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">Order #</th>
                        <th class="table-header">Customer</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">Total</th>
                        <th class="table-header">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentOrders as $order)
                        <tr>
                            <td class="table-cell font-medium text-brand">{{ $order->order_number }}</td>
                            <td class="table-cell">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="table-cell"><span class="badge {{ $order->status_badge_class }}">{{ ucfirst($order->order_status) }}</span></td>
                            <td class="table-cell font-bold">K {{ number_format($order->total, 2) }}</td>
                            <td class="table-cell"><a href="{{ route('admin.orders.show', $order) }}" class="text-brand hover:underline text-sm">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Order Status Distribution --}}
    <div class="card p-5">
        <h2 class="font-bold text-gray-800 mb-4">Orders by Status</h2>
        <div class="space-y-3">
            @foreach($ordersByStatus as $status => $count)
                @php
                    $colors = [
                        'pending'    => 'bg-yellow-400',
                        'processing' => 'bg-blue-400',
                        'paid'       => 'bg-green-400',
                        'shipped'    => 'bg-indigo-400',
                        'delivered'  => 'bg-green-600',
                        'cancelled'  => 'bg-red-400',
                        'refunded'   => 'bg-gray-400',
                    ];
                    $color = $colors[$status] ?? 'bg-gray-400';
                    $pct = $totalOrders > 0 ? round(($count / $totalOrders) * 100) : 0;
                @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="capitalize font-medium text-gray-700">{{ ucfirst($status) }}</span>
                        <span class="text-gray-500">{{ $count }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="{{ $color }} h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Low Stock --}}
    <div class="card">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Low Stock Alert
                </h2>
            <a href="{{ route('admin.reports.inventory') }}" class="text-sm text-brand hover:underline">View Report</a>
        </div>
        @if($lowStockProducts->isEmpty())
            <p class="p-5 text-gray-400 text-sm">No low stock products.</p>
        @else
            <div class="divide-y divide-gray-50">
                @foreach($lowStockProducts as $p)
                    <div class="flex items-center justify-between px-5 py-3">
                        <a href="{{ route('admin.products.edit', $p) }}" class="text-sm font-medium text-gray-700 hover:text-brand truncate max-w-xs">{{ $p->name }}</a>
                        <span class="badge {{ $p->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }} font-bold ml-2 flex-shrink-0">
                            {{ $p->stock == 0 ? 'Out of Stock' : $p->stock.' left' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Top Products --}}
    <div class="card">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Top Products
                </h2>
            <a href="{{ route('admin.reports.products') }}" class="text-sm text-brand hover:underline">Full Report</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($topProducts as $i => $p)
                <div class="flex items-center gap-3 px-5 py-3">
                    <span class="w-6 h-6 rounded-full bg-brand text-white text-xs flex items-center justify-center font-bold flex-shrink-0">{{ $i+1 }}</span>
                    <a href="{{ route('admin.products.edit', $p) }}" class="text-sm font-medium text-gray-700 hover:text-brand flex-1 truncate">{{ $p->name }}</a>
                    <span class="text-sm text-gray-500 flex-shrink-0">{{ $p->total_sold ?? 0 }} sold</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
