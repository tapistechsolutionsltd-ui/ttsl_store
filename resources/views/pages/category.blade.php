@extends('layouts.app')
@section('title', $category->name)

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold">{{ $category->name }}</h1>
        <p class="text-blue-100 mt-1">{{ $products->total() }} products</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    {{-- Sub-category or description strip --}}
    @if($category->description)
        <p class="text-gray-600 mb-8 max-w-3xl">{{ $category->description }}</p>
    @endif

    {{-- Sort bar --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-500 text-sm">{{ $products->total() }} products in <span class="font-medium text-gray-700">{{ $category->name }}</span></p>
        <select onchange="window.location=this.value"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand">
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest First</option>
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name A–Z</option>
        </select>
    </div>

    @if($products->isEmpty())
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No products in this category yet</h3>
            <a href="{{ route('shop') }}" class="btn-primary mt-4">Browse All Products</a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    @endif
</div>
@endsection
