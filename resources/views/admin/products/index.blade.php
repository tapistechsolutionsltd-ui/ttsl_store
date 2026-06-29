@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.products.create') }}" class="btn-primary btn-sm">+ Add Product</a>
</div>

{{-- Filters --}}
<form method="GET" class="card p-4 mb-6 flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
        class="input-field py-2 text-sm flex-1 min-w-48" />
    <select name="category" class="input-field py-2 text-sm w-44">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <select name="status" class="input-field py-2 text-sm w-36">
        <option value="">All Status</option>
        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
    </select>
    <button type="submit" class="btn-primary btn-sm">Search</button>
    <a href="{{ route('admin.products.index') }}" class="btn-secondary btn-sm">Reset</a>
</form>

<div class="card overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="table-header">Product</th>
                <th class="table-header">SKU</th>
                <th class="table-header">Category</th>
                <th class="table-header">Price</th>
                <th class="table-header">Slots</th>
                <th class="table-header">Status</th>
                <th class="table-header">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="table-cell">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->primary_image_url }}" alt=""
                                 class="w-12 h-12 object-cover rounded-lg flex-shrink-0"
                                 onerror="this.src='https://via.placeholder.com/50?text=N/A'" />
                            <span class="font-medium text-gray-800 max-w-xs truncate">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="table-cell text-gray-400 font-mono text-xs">{{ $product->sku }}</td>
                    <td class="table-cell">{{ $product->category->name ?? '—' }}</td>
                    <td class="table-cell">
                        <div class="font-bold text-brand">K {{ number_format($product->price, 2) }}</div>
                        @if($product->sale_price)
                            <div class="text-xs text-red-500">Sale: K {{ number_format($product->sale_price, 2) }}</div>
                        @endif
                    </td>
                    <td class="table-cell">
                        @if($product->stock == 0)
                            <span class="badge bg-red-100 text-red-600 text-xs">Unavailable</span>
                        @elseif($product->stock <= 3)
                            <span class="font-semibold text-yellow-600 text-sm">{{ $product->stock }} left</span>
                        @else
                            <span class="font-semibold text-green-600 text-sm">{{ $product->stock }} slots</span>
                        @endif
                    </td>
                    <td class="table-cell">
                        <span class="badge {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : ($product->status === 'draft' ? 'bg-gray-100 text-gray-600' : 'bg-red-100 text-red-600') }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td class="table-cell">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                onsubmit="return askConfirmForm(event, 'Are you sure you want to delete this product? All associated data will be removed.', 'Delete Product');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No products found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $products->links() }}</div>
</div>
@endsection
