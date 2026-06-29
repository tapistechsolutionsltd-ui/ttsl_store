@extends('layouts.admin')
@section('title', 'Customers')

@section('content')
<form method="GET" class="card p-4 mb-6 flex gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
        class="input-field py-2 text-sm flex-1" />
    <button type="submit" class="btn-primary btn-sm">Search</button>
    <a href="{{ route('admin.customers.index') }}" class="btn-secondary btn-sm">Reset</a>
</form>
<div class="card overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b"><tr>
            <th class="table-header">Customer</th>
            <th class="table-header">Email</th>
            <th class="table-header">Orders</th>
            <th class="table-header">Status</th>
            <th class="table-header">Joined</th>
            <th class="table-header">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($customers as $customer)
                <tr class="hover:bg-gray-50">
                    <td class="table-cell">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="table-cell text-gray-500">{{ $customer->email }}</td>
                    <td class="table-cell font-semibold">{{ $customer->orders_count }}</td>
                    <td class="table-cell">
                        <span class="badge {{ $customer->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ ucfirst($customer->status) }}
                        </span>
                    </td>
                    <td class="table-cell text-gray-400 text-xs">{{ $customer->created_at->format('d M Y') }}</td>
                    <td class="table-cell">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-brand hover:underline text-sm">View</a>
                            <form method="POST" action="{{ route('admin.customers.toggle', $customer) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-sm {{ $customer->status === 'active' ? 'text-red-500' : 'text-green-600' }}">
                                    {{ $customer->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No customers found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $customers->links() }}</div>
</div>
@endsection
