@extends('layouts.admin')
@section('title', 'CPP Clients')

@section('content')
<form method="GET" class="card p-4 mb-6 flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search company, code, customer..."
        class="input-field py-2 text-sm flex-1 min-w-48" />
    <select name="status" class="input-field py-2 text-sm w-48">
        <option value="">All Statuses</option>
        @foreach(\App\Models\CppClient::TIMELINE_STATUSES as $key => $label)
            <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-primary btn-sm">Search</button>
    <a href="{{ route('admin.cpp.clients.index') }}" class="btn-secondary btn-sm">Reset</a>
</form>

<div class="card overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="table-header">Company</th>
                <th class="table-header">Promotion Code</th>
                <th class="table-header">Customer</th>
                <th class="table-header">Product</th>
                <th class="table-header">Status</th>
                <th class="table-header">Registered</th>
                <th class="table-header">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($clients as $client)
                <tr class="hover:bg-gray-50 transition-colors {{ !$client->is_active ? 'opacity-50' : '' }}">
                    <td class="table-cell font-medium text-gray-800">{{ $client->company_name ?? '—' }}</td>
                    <td class="table-cell font-mono text-xs text-brand">{{ $client->activeCode->code ?? '—' }}</td>
                    <td class="table-cell">{{ $client->user->name ?? '—' }}</td>
                    <td class="table-cell">{{ $client->product->name ?? '—' }}</td>
                    <td class="table-cell"><span class="badge bg-blue-100 text-blue-700">{{ $client->current_timeline_label }}</span></td>
                    <td class="table-cell text-sm text-gray-500">{{ $client->created_at->format('d M Y') }}</td>
                    <td class="table-cell">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.cpp.clients.show', $client) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                            <form method="POST" action="{{ route('admin.cpp.clients.deactivate', $client) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">{{ $client->is_active ? 'Deactivate' : 'Reactivate' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.cpp.clients.destroy', $client) }}"
                                onsubmit="return askConfirmForm(event, 'Delete this client record?', 'Delete Client');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No clients found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $clients->links() }}</div>
</div>
@endsection
