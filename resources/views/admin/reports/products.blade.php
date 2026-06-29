@extends('layouts.admin')
@section('title', 'Product Report')

@section('content')
<div class="card overflow-hidden">
    <div class="p-5 border-b"><h2 class="font-bold text-gray-800">Products by Sales Performance</h2></div>
    <table class="w-full">
        <thead class="bg-gray-50"><tr>
            <th class="table-header">#</th>
            <th class="table-header">Product</th>
            <th class="table-header">Category</th>
            <th class="table-header">Units Sold</th>
            <th class="table-header">Revenue</th>
            <th class="table-header">Stock</th>
        </tr></thead>
        <tbody class="divide-y">
            @forelse($products as $i => $p)
                <tr>
                    <td class="table-cell text-gray-400">{{ $products->firstItem() + $i }}</td>
                    <td class="table-cell font-medium">{{ $p->name }}</td>
                    <td class="table-cell text-gray-500">{{ $p->category->name ?? '—' }}</td>
                    <td class="table-cell font-bold">{{ $p->units_sold ?? 0 }}</td>
                    <td class="table-cell font-bold text-brand">K {{ number_format($p->order_items_sum_total ?? 0, 2) }}</td>
                    <td class="table-cell">
                        <span class="{{ $p->stock == 0 ? 'text-red-600' : ($p->stock <= 5 ? 'text-yellow-600' : 'text-green-600') }} font-semibold">
                            {{ $p->stock }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No data</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $products->links() }}</div>
</div>
@endsection
