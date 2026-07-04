@extends('layouts.admin')
@section('title', 'Promotions')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.cpp.promotions.create') }}" class="btn-primary btn-sm">+ New Promotion</a>
</div>

<form method="GET" class="card p-4 mb-6 flex flex-wrap gap-3">
    <select name="status" class="input-field py-2 text-sm w-44">
        <option value="">All Status</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
    </select>
    <button type="submit" class="btn-primary btn-sm">Filter</button>
    <a href="{{ route('admin.cpp.promotions.index') }}" class="btn-secondary btn-sm">Reset</a>
</form>

<div class="card overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="table-header">Title</th>
                <th class="table-header">Status</th>
                <th class="table-header">Clients</th>
                <th class="table-header">Max</th>
                <th class="table-header">Expiry</th>
                <th class="table-header">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($promotions as $promo)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="table-cell font-medium text-gray-800">{{ $promo->title }}</td>
                    <td class="table-cell">
                        <span class="badge {{ $promo->effective_status === 'published' ? 'bg-green-100 text-green-700' : ($promo->effective_status === 'draft' ? 'bg-gray-100 text-gray-600' : 'bg-red-100 text-red-600') }}">
                            {{ ucfirst($promo->effective_status) }}
                        </span>
                    </td>
                    <td class="table-cell">{{ $promo->clients_count }}</td>
                    <td class="table-cell">{{ $promo->max_clients ?? 'Unlimited' }}</td>
                    <td class="table-cell text-sm text-gray-500">{{ optional($promo->expiry_date)->format('d M Y') ?? '—' }}</td>
                    <td class="table-cell">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('cpp.show', $promo) }}" target="_blank" class="text-gray-500 hover:text-brand text-sm font-medium">View</a>
                            <a href="{{ route('admin.cpp.promotions.edit', $promo) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.cpp.promotions.destroy', $promo) }}"
                                onsubmit="return askConfirmForm(event, 'Delete this promotion? All linked client records will be removed.', 'Delete Promotion');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No promotions found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $promotions->links() }}</div>
</div>
@endsection
