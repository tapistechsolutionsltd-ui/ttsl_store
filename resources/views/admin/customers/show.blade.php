@extends('layouts.admin')
@section('title', $user->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card p-5">
        <div class="text-center mb-4">
            <div class="w-16 h-16 bg-brand rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h2 class="font-bold text-lg mt-3">{{ $user->name }}</h2>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            <span class="badge mt-2 {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                {{ ucfirst($user->status) }}
            </span>
        </div>
        <div class="space-y-2 text-sm border-t pt-4">
            @if($user->phone)
                <div class="flex justify-between"><span class="text-gray-500">Phone</span><span>{{ $user->phone }}</span></div>
            @endif
            <div class="flex justify-between"><span class="text-gray-500">Joined</span><span>{{ $user->created_at->format('d M Y') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Total Orders</span><span class="font-semibold">{{ $user->orders->count() }}</span></div>
        </div>
        <form method="POST" action="{{ route('admin.customers.toggle', $user) }}" class="mt-4">
            @csrf @method('PATCH')
            <button type="submit" class="w-full {{ $user->status === 'active' ? 'btn-danger' : 'btn-primary' }} btn-sm">
                {{ $user->status === 'active' ? 'Deactivate Account' : 'Activate Account' }}
            </button>
        </form>
    </div>
    <div class="lg:col-span-2 card overflow-hidden">
        <div class="p-5 border-b"><h2 class="font-bold text-gray-800">Recent Orders</h2></div>
        <table class="w-full">
            <thead class="bg-gray-50"><tr>
                <th class="table-header">Order #</th>
                <th class="table-header">Date</th>
                <th class="table-header">Status</th>
                <th class="table-header">Total</th>
            </tr></thead>
            <tbody class="divide-y">
                @forelse($user->orders as $order)
                    <tr>
                        <td class="table-cell font-medium text-brand">
                            <a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a>
                        </td>
                        <td class="table-cell text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="table-cell"><span class="badge {{ $order->status_badge_class }}">{{ ucfirst($order->order_status) }}</span></td>
                        <td class="table-cell font-bold text-brand">K {{ number_format($order->total, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-8 text-gray-400">No orders yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
