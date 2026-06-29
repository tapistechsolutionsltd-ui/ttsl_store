@extends('layouts.app')
@section('title', 'Shop')

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold">{{ request('q') ? 'Search: "'.request('q').'"' : 'All Products' }}</h1>
        <p class="text-blue-100 mt-1">{{ $products->total() }} products found</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8"
     x-data="{
         filterOpen: false,
         catOpen: true,
         brandOpen: true,
         priceOpen: true,
         closeFilter() { if (window.innerWidth < 1024) this.filterOpen = false; }
     }"
     x-on:app:before-navigate.window="filterOpen = false">

    {{-- Mobile filter hook tab: fixed to left edge, visible when drawer is closed --}}
    <button @click="filterOpen = true"
            x-show="!filterOpen"
            class="fixed left-0 top-1/2 -translate-y-1/2 z-40 lg:hidden
                   bg-[#0a2540] text-white rounded-r-xl shadow-xl
                   py-5 px-2.5 flex flex-col items-center gap-1.5 focus:outline-none"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
        </svg>
        <span class="text-[10px] font-bold tracking-wider"
              style="writing-mode: vertical-rl; text-orientation: mixed; transform: rotate(180deg);">
            FILTER
        </span>
    </button>

    {{-- Mobile overlay backdrop --}}
    <div x-show="filterOpen"
         @click="filterOpen = false"
         class="fixed inset-0 bg-black/50 z-30 lg:hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar Filters --}}
        <aside class="lg:w-64 flex-shrink-0">

            {{-- On mobile: fixed slide-in drawer from left; on lg+: normal sticky sidebar --}}
            <div class="fixed top-0 left-0 h-full w-72 bg-white shadow-2xl z-40
                        overflow-y-auto transition-transform duration-300
                        lg:relative lg:w-full lg:h-auto lg:shadow-none lg:z-auto lg:overflow-visible lg:translate-x-0
                        [view-transition-name:shop-filter-drawer]"
                 :class="filterOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

                {{-- Mobile-only drawer header --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 sticky top-0 bg-white z-10 lg:hidden">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span class="font-bold text-gray-900">Filters</span>
                    </div>
                    <button @click="filterOpen = false"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Filter card content --}}
                <div class="p-5 lg:p-0">
                    <div class="card p-5 lg:sticky lg:top-24">
                        <h3 class="font-bold text-gray-900 mb-4 hidden lg:block">Filters</h3>

                        {{-- Categories --}}
                        <div class="mb-5">
                            <button @click="catOpen = !catOpen"
                                    class="flex items-center justify-between w-full font-semibold text-gray-700 mb-3">
                                Categories
                                <svg class="w-4 h-4 transition-transform" :class="catOpen ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="catOpen" class="space-y-2">
                                <a href="{{ route('shop') }}" @click="closeFilter()"
                                   class="block text-sm py-1 px-2 rounded {{ !request('category') ? 'text-brand font-semibold bg-blue-50' : 'text-gray-600 hover:text-brand' }}">
                                    All Categories
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('shop') }}?category={{ $cat->slug }}" @click="closeFilter()"
                                       class="block text-sm py-1 px-2 rounded {{ request('category') === $cat->slug ? 'text-brand font-semibold bg-blue-50' : 'text-gray-600 hover:text-brand' }}">
                                        {{ $cat->name }}
                                        <span class="text-xs text-gray-400">({{ $cat->active_products_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Brands --}}
                        <div class="mb-5 border-t pt-4">
                            <button @click="brandOpen = !brandOpen"
                                    class="flex items-center justify-between w-full font-semibold text-gray-700 mb-3">
                                Brands
                                <svg class="w-4 h-4 transition-transform" :class="brandOpen ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="brandOpen" class="space-y-2">
                                @foreach($brands as $brand)
                                    <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->slug]) }}"
                                       @click="closeFilter()"
                                       class="block text-sm py-1 px-2 rounded {{ request('brand') === $brand->slug ? 'text-brand font-semibold bg-blue-50' : 'text-gray-600 hover:text-brand' }}">
                                        {{ $brand->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price Range --}}
                        <div class="border-t pt-4">
                            <button @click="priceOpen = !priceOpen"
                                    class="flex items-center justify-between w-full font-semibold text-gray-700 mb-3">
                                Price Range (K)
                                <svg class="w-4 h-4 transition-transform" :class="priceOpen ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="priceOpen">
                                <form method="GET" action="{{ route('shop') }}" class="space-y-3"
                                      @submit="filterOpen = false">
                                    <input type="hidden" name="category" value="{{ request('category') }}" />
                                    <input type="hidden" name="q" value="{{ request('q') }}" />
                                    <div class="flex gap-2">
                                        <input type="number" name="min_price" placeholder="Min"
                                               value="{{ request('min_price') }}"
                                               class="input-field text-sm py-2 px-3" />
                                        <input type="number" name="max_price" placeholder="Max"
                                               value="{{ request('max_price') }}"
                                               class="input-field text-sm py-2 px-3" />
                                    </div>
                                    <button type="submit" class="btn-primary w-full btn-sm text-sm">Apply</button>
                                </form>
                            </div>
                        </div>

                        {{-- In Stock Only --}}
                        <div class="border-t pt-4 mt-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded text-brand"
                                    onchange="window.location='{{ route('shop') }}?'+new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), in_stock: this.checked ? 1 : ''}).toString()"
                                    {{ request('in_stock') ? 'checked' : '' }} />
                                <span class="text-sm text-gray-700">In Stock Only</span>
                            </label>
                        </div>

                        @if(request()->hasAny(['category', 'brand', 'min_price', 'max_price', 'q', 'in_stock']))
                            <a href="{{ route('shop') }}" @click="closeFilter()"
                               class="flex items-center justify-center gap-1 text-sm text-red-500 hover:text-red-700 mt-4 border-t pt-4">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Clear All Filters
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </aside>

        {{-- Products Grid --}}
        <div class="flex-1 min-w-0">
            {{-- Sort bar --}}
            <div class="flex items-center justify-between mb-6 gap-2">
                <p class="text-gray-500 text-sm truncate">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</p>
                <select onchange="window.location=this.value"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand flex-shrink-0">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest First</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name A–Z</option>
                </select>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No products found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your filters or search query</p>
                    <a href="{{ route('shop') }}" class="btn-primary">Browse All Products</a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
