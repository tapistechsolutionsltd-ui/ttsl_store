@extends('layouts.admin')
@section('title', 'Add-on Features')

@section('content')
<div class="mb-4">
    <p class="text-sm text-gray-500">
        These add-on features appear on every product page as optional extras customers can select.
        The base price shown on the storefront stays the standard website development price — each
        selected feature adds its price on top.
    </p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 card overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b"><tr>
                <th class="table-header">Feature</th>
                <th class="table-header">Price</th>
                <th class="table-header">Order</th>
                <th class="table-header">Status</th>
                <th class="table-header">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($features as $feature)
                    <tr class="hover:bg-gray-50 transition-colors" x-data="{ editing: false }">
                        <td class="table-cell">
                            <div class="font-medium">{{ $feature->name }}</div>
                            @if($feature->description)
                                <div class="text-xs text-gray-400 mt-0.5 max-w-xs">{{ $feature->description }}</div>
                            @endif
                        </td>
                        <td class="table-cell font-semibold text-brand">K {{ number_format($feature->price, 2) }}</td>
                        <td class="table-cell text-gray-500">{{ $feature->sort_order }}</td>
                        <td class="table-cell">
                            <span class="badge {{ $feature->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                {{ $feature->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="table-cell">
                            <div class="flex gap-2 mb-1">
                                <button @click="editing = !editing" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                                <form method="POST" action="{{ route('admin.features.destroy', $feature) }}"
                                    onsubmit="return askConfirmForm(event, 'Are you sure you want to delete this feature? This action cannot be undone.', 'Delete Feature');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                                </form>
                            </div>
                            <div x-show="editing" x-transition class="mt-2">
                                <form method="POST" action="{{ route('admin.features.update', $feature) }}"
                                      class="p-3 bg-gray-50 rounded-lg space-y-2 border border-gray-200">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $feature->name }}" class="input-field py-1.5 text-sm" required placeholder="Feature name" />
                                    <textarea name="description" rows="2" class="input-field py-1.5 text-sm" placeholder="Short description (optional)">{{ $feature->description }}</textarea>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="number" step="0.01" min="0" name="price" value="{{ $feature->price }}" class="input-field py-1.5 text-sm" required placeholder="Price (K)" />
                                        <input type="number" min="0" name="sort_order" value="{{ $feature->sort_order }}" class="input-field py-1.5 text-sm" placeholder="Sort order" />
                                    </div>
                                    <select name="status" class="input-field py-1.5 text-sm">
                                        <option value="1" {{ $feature->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$feature->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <div class="flex gap-2">
                                        <button type="submit" class="btn-primary btn-sm text-xs">Save</button>
                                        <button type="button" @click="editing = false" class="btn-secondary btn-sm text-xs">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-12 text-gray-400">No add-on features yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card p-6">
        <h2 class="font-bold text-gray-800 mb-4">Add Feature</h2>
        <form method="POST" action="{{ route('admin.features.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Feature Name *</label>
                <input type="text" name="name" class="input-field" required placeholder="e.g. SEO Package" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="2" class="input-field" placeholder="Shown under the feature name to customers"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (K) *</label>
                <input type="number" step="0.01" min="0" name="price" class="input-field" required placeholder="0.00" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" min="0" name="sort_order" class="input-field" placeholder="0" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="input-field">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn-primary w-full">Add Feature</button>
        </form>
    </div>
</div>
@endsection
