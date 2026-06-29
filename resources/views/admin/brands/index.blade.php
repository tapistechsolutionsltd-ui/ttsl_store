@extends('layouts.admin')
@section('title', 'DevTools')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 card overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b"><tr>
                <th class="table-header">DevTool</th>
                <th class="table-header">Website URL</th>
                <th class="table-header">Products</th>
                <th class="table-header">Status</th>
                <th class="table-header">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($brands as $brand)
                    <tr class="hover:bg-gray-50 transition-colors" x-data="{ editing: false }">
                        <td class="table-cell">
                            <div class="flex items-center gap-3">
                                @if($brand->logo)
                                    <img src="{{ asset('storage/'.$brand->logo) }}" class="h-8 object-contain" />
                                @else
                                    <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-xs font-bold text-gray-500">D</div>
                                @endif
                                <span class="font-medium">{{ $brand->name }}</span>
                            </div>
                        </td>
                        <td class="table-cell">
                            @if($brand->website_url)
                                <a href="{{ $brand->website_url }}" target="_blank" rel="noopener"
                                   class="text-brand hover:underline text-xs truncate max-w-[160px] block">
                                    {{ $brand->website_url }}
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="table-cell">{{ $brand->products_count }}</td>
                        <td class="table-cell">
                            <span class="badge {{ $brand->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                {{ $brand->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="table-cell">
                            <div class="flex gap-2 mb-1">
                                <button @click="editing = !editing" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                                <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}"
                                    onsubmit="return askConfirmForm(event, 'Are you sure you want to delete this DevTool? This action cannot be undone.', 'Delete DevTool');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                                </form>
                            </div>
                            <div x-show="editing" x-transition class="mt-2">
                                <form method="POST" action="{{ route('admin.brands.update', $brand) }}"
                                      enctype="multipart/form-data"
                                      class="p-3 bg-gray-50 rounded-lg space-y-2 border border-gray-200">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $brand->name }}" class="input-field py-1.5 text-sm" required placeholder="Tool name" />
                                    <input type="url" name="website_url" value="{{ $brand->website_url }}" class="input-field py-1.5 text-sm" placeholder="https://example.com" />
                                    <div class="flex items-center gap-2">
                                        <select name="status" class="input-field py-1.5 text-sm flex-1">
                                            <option value="1" {{ $brand->status ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$brand->status ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-0.5">Replace Logo / Icon</label>
                                        <input type="file" name="logo" accept="image/*" class="input-field py-1 text-xs" />
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="btn-primary btn-sm text-xs">Save</button>
                                        <button type="button" @click="editing = false" class="btn-secondary btn-sm text-xs">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-12 text-gray-400">No DevTools yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card p-6">
        <h2 class="font-bold text-gray-800 mb-4">Add DevTool</h2>
        <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tool Name *</label>
                <input type="text" name="name" class="input-field" required placeholder="e.g. Laravel, Vue.js" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                <input type="url" name="website_url" class="input-field" placeholder="https://laravel.com" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Logo / Icon</label>
                <input type="file" name="logo" accept="image/*" class="input-field py-2 text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="input-field">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn-primary w-full">Add DevTool</button>
        </form>
    </div>
</div>
@endsection
