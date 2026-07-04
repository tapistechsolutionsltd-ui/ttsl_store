@extends('layouts.admin')
@section('title', 'Promotion Codes')

@section('content')
<form method="GET" class="card p-4 mb-6 flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search code..."
        class="input-field py-2 text-sm flex-1 min-w-48" />
    <select name="status" class="input-field py-2 text-sm w-40">
        <option value="">All Status</option>
        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    <button type="submit" class="btn-primary btn-sm">Search</button>
    <a href="{{ route('admin.cpp.codes.index') }}" class="btn-secondary btn-sm">Reset</a>
</form>

<div class="card overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="table-header">Code</th>
                <th class="table-header">Promotion</th>
                <th class="table-header">Customer</th>
                <th class="table-header">Product</th>
                <th class="table-header">Status</th>
                <th class="table-header">Generated</th>
                <th class="table-header">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($codes as $code)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="table-cell font-mono font-bold text-brand">{{ $code->code }}</td>
                    <td class="table-cell">{{ $code->promotion->title ?? '—' }}</td>
                    <td class="table-cell">{{ $code->client->user->name ?? '—' }}</td>
                    <td class="table-cell">{{ $code->client->product->name ?? '—' }}</td>
                    <td class="table-cell">
                        <span class="badge {{ $code->status === 'active' ? 'bg-green-100 text-green-700' : ($code->status === 'expired' ? 'bg-gray-100 text-gray-600' : 'bg-red-100 text-red-600') }}">
                            {{ ucfirst($code->status) }}
                        </span>
                    </td>
                    <td class="table-cell text-sm text-gray-500">{{ $code->generated_at->format('d M Y') }}</td>
                    <td class="table-cell">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.cpp.clients.show', $code->cpp_client_id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Client</a>
                            @if($code->status === 'active')
                                <form method="POST" action="{{ route('admin.cpp.codes.expire', $code) }}">
                                    @csrf @method('PATCH')
                                    <button class="text-xs text-yellow-600 hover:underline">Expire</button>
                                </form>
                                <form method="POST" action="{{ route('admin.cpp.codes.cancel', $code) }}">
                                    @csrf @method('PATCH')
                                    <button class="text-xs text-red-500 hover:underline">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No codes found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $codes->links() }}</div>
</div>
@endsection
