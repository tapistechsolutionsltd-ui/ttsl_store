@extends('layouts.app')
@section('title', 'My Account')

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold">My Account</h1>
        <p class="text-blue-100 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">

    @php
        $navLinks = [
            ['route' => 'account.dashboard', 'label' => 'Dashboard', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
            ['route' => 'account.orders', 'label' => 'My Orders', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>'],
            ['route' => 'account.wishlist', 'label' => 'Wishlist', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>'],
            ['route' => 'account.addresses', 'label' => 'Addresses', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>'],
            ['route' => 'account.profile', 'label' => 'Profile', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
        ];
    @endphp

    {{-- Mobile account nav: compact user info + horizontal scrollable pill tabs --}}
    <div class="lg:hidden mb-6">
        <div class="flex items-center gap-3 p-4 bg-white rounded-2xl shadow-sm border border-gray-100 mb-3">
            <div class="w-10 h-10 bg-brand rounded-full flex items-center justify-center text-white text-lg font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="font-semibold text-sm text-gray-800 truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</div>
            </div>
        </div>
        <div class="overflow-x-auto hide-scrollbar -mx-4 px-4">
            <div class="flex items-center gap-2 pb-1">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="flex-shrink-0 flex items-center gap-1.5 px-3.5 py-2 rounded-full text-sm font-medium transition-colors whitespace-nowrap
                              {{ request()->routeIs($link['route']) ? 'bg-brand text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-200 hover:border-brand hover:text-brand' }}">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $link['svg'] !!}
                        </svg>
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-1.5 px-3.5 py-2 rounded-full text-sm font-medium text-red-500 bg-white border border-red-200 hover:bg-red-50 transition-colors whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Grid: sidebar (desktop only) + main content --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- Sidebar: desktop only --}}
        <aside class="hidden lg:block lg:col-span-1">
            <div class="card p-5 sticky top-24">
                <div class="flex items-center gap-3 mb-5 pb-5 border-b border-gray-100">
                    <div class="w-12 h-12 bg-brand rounded-full flex items-center justify-center text-white text-xl font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-400">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <nav class="space-y-1">
                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->routeIs($link['route']) ? 'bg-brand text-white font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $link['svg'] !!}
                            </svg>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                    <hr class="my-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-red-500 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="col-span-1 lg:col-span-3">
            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-8">
                <div class="stat-card text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-brand">{{ $orderCount }}</div>
                    <div class="text-xs sm:text-sm text-gray-500 mt-1">Total Orders</div>
                </div>
                <div class="stat-card text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-green-600">
                        {{ auth()->user()->orders()->where('order_status', 'delivered')->count() }}
                    </div>
                    <div class="text-xs sm:text-sm text-gray-500 mt-1">Delivered</div>
                </div>
                <div class="stat-card text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-accent">{{ $wishlistCount }}</div>
                    <div class="text-xs sm:text-sm text-gray-500 mt-1">Wishlist Items</div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="card overflow-hidden">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h2 class="font-bold text-gray-800">Recent Orders</h2>
                    <a href="{{ route('account.orders') }}" class="text-sm text-brand hover:underline">View All</a>
                </div>
                @if($recentOrders->isEmpty())
                    <div class="p-10 text-center text-gray-500">
                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <p>You haven't placed any orders yet.</p>
                        <a href="{{ route('shop') }}" class="btn-primary btn-sm mt-4 inline-block">Start Shopping</a>
                    </div>
                @else
                    <div class="divide-y divide-gray-50">
                        @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors gap-3">
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-sm truncate">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge {{ $order->status_badge_class }} text-xs">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="font-bold text-brand text-sm">K {{ number_format($order->total, 2) }}</p>
                                    <a href="{{ route('account.order.detail', $order) }}"
                                       class="text-xs text-brand hover:underline">Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
