@extends('layouts.admin')
@section('title', 'Categories')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-3">
        <div class="card overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b"><tr>
                    <th class="table-header">Category</th>
                    <th class="table-header">Products</th>
                    <th class="table-header">Status</th>
                    <th class="table-header">Order</th>
                    <th class="table-header">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50" id="cat-table-body">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell">
                                <div class="flex items-center gap-3">
                                    @if($cat->image)
                                        <img src="{{ asset('storage/'.$cat->image) }}" class="w-10 h-10 object-cover rounded-lg" />
                                    @else
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-brand">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                        </div>
                                    @endif
                                    <span class="font-medium">{{ $cat->name }}</span>
                                </div>
                            </td>
                            <td class="table-cell">{{ $cat->products_count }}</td>
                            <td class="table-cell">
                                <span class="badge {{ $cat->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    {{ $cat->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="table-cell">{{ $cat->sort_order }}</td>
                            <td class="table-cell">
                                <div class="flex gap-2">
                                    <button type="button"
                                        onclick="openCatEdit({{ $cat->id }}, {{ json_encode($cat->name) }}, {{ $cat->status ? 1 : 0 }}, {{ $cat->sort_order }})"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                        onsubmit="return askConfirmForm(event, 'Are you sure you want to delete this category? This action cannot be undone.', 'Delete Category');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-12 text-gray-400">No categories yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Category --}}
    <div class="card p-6">
        <h2 class="font-bold text-gray-800 mb-4">Add Category</h2>
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input type="text" name="name" class="input-field @error('name') border-red-500 @enderror" required />
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="2" class="input-field text-sm"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <input type="file" name="image" accept="image/*" class="input-field py-2 text-sm" />
            </div>
            <div class="flex gap-3">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="input-field" />
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="input-field">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-primary w-full">Add Category</button>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="cat-edit-modal" class="fixed inset-0 z-[200] flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeCatEdit()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10 overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-brand to-brand-dark"></div>
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Category</h3>
            <form id="cat-edit-form" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" id="cat-edit-name" name="name" class="input-field" required />
                </div>
                <div class="flex gap-3">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="cat-edit-status" name="status" class="input-field">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" id="cat-edit-order" name="sort_order" class="input-field" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Replace Image</label>
                    <input type="file" name="image" accept="image/*" class="input-field py-2 text-sm" />
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary flex-1">Save Changes</button>
                    <button type="button" onclick="closeCatEdit()" class="btn-secondary flex-1">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
var catRouteBase = '{{ url('/admin/categories') }}';

function openCatEdit(id, name, status, sortOrder) {
    document.getElementById('cat-edit-name').value    = name;
    document.getElementById('cat-edit-status').value  = status;
    document.getElementById('cat-edit-order').value   = sortOrder;
    document.getElementById('cat-edit-form').action   = catRouteBase + '/' + id;
    document.getElementById('cat-edit-modal').classList.remove('hidden');
}

function closeCatEdit() {
    document.getElementById('cat-edit-modal').classList.add('hidden');
}
</script>
@endpush
@endsection
