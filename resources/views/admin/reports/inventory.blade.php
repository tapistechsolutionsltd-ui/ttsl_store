@extends('layouts.admin')
@section('title', 'Inventory Report')

@section('content')
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="stat-card text-center">
        <div class="text-2xl font-bold text-red-600">{{ $outOfStock->count() }}</div>
        <div class="text-sm text-gray-500 mt-1">Out of Stock</div>
    </div>
    <div class="stat-card text-center">
        <div class="text-2xl font-bold text-yellow-600">{{ $lowStock->count() }}</div>
        <div class="text-sm text-gray-500 mt-1">Low Stock (≤10)</div>
    </div>
</div>

@if($lowStock->isNotEmpty())
    <div class="card overflow-hidden mb-6">
        <div class="p-5 border-b bg-yellow-50">
            <h2 class="font-bold text-yellow-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Low Stock Products
            </h2>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50"><tr>
                <th class="table-header">Product</th>
                <th class="table-header">SKU</th>
                <th class="table-header">Stock</th>
                <th class="table-header">Action</th>
            </tr></thead>
            <tbody class="divide-y">
                @foreach($lowStock as $p)
                    <tr>
                        <td class="table-cell font-medium">{{ $p->name }}</td>
                        <td class="table-cell font-mono text-xs text-gray-400">{{ $p->sku }}</td>
                        <td class="table-cell">
                            <span class="font-bold {{ $p->stock == 0 ? 'text-red-600' : 'text-yellow-600' }}">{{ $p->stock }}</span>
                        </td>
                        <td class="table-cell">
                            <a href="{{ route('admin.products.edit', $p) }}" class="text-brand hover:underline text-sm">Update Stock</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<div class="card overflow-hidden">
    <div class="p-5 border-b"><h2 class="font-bold text-gray-800">All Products Inventory</h2></div>
    <table class="w-full">
        <thead class="bg-gray-50"><tr>
            <th class="table-header">Product</th>
            <th class="table-header">Category</th>
            <th class="table-header">Stock</th>
            <th class="table-header">Price</th>
        </tr></thead>
        <tbody class="divide-y">
            @foreach($allProducts as $p)
                <tr>
                    <td class="table-cell">{{ $p->name }}</td>
                    <td class="table-cell text-gray-500">{{ $p->category->name ?? '—' }}</td>
                    <td class="table-cell">
                        <span class="font-semibold {{ $p->stock == 0 ? 'text-red-600' : ($p->stock <= 10 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ $p->stock }}
                        </span>
                    </td>
                    <td class="table-cell">K {{ number_format($p->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $allProducts->links() }}</div>
</div>
@endsection
