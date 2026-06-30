<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="/favicon.png" />
    <title>@yield('title', 'Home') | TTSL Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

@include('components.page-loader')

{{-- ════════════════════════════════════════════════════════════
     HEADER
════════════════════════════════════════════════════════════ --}}
<header class="bg-brand-dark text-white sticky top-0 z-50"
        x-data="{ mobileOpen: false }"
        x-on:app:before-navigate.window="mobileOpen = false">

    {{-- ── Row 1: Logo · Search · Account · Cart ─────────────── --}}
    <div class="max-w-screen-2xl mx-auto px-3 sm:px-4">
        <div class="flex items-center gap-2 sm:gap-3 h-14 sm:h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('images/ttsolutions_logo.png') }}" alt="TTSolutions Limited"
                     class="w-auto object-contain" style="height: 46px;">
            </a>

            {{-- Deliver to (lg+) --}}
            <div class="hidden lg:flex flex-col leading-tight flex-shrink-0 border border-transparent hover:border-white/60 rounded px-1 py-0.5 cursor-default">
                <span class="text-xs text-gray-300">Deliver to</span>
                <span class="text-xs font-bold whitespace-nowrap flex items-center gap-0.5">
                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Papua New Guinea
                </span>
            </div>

            {{-- Search bar (hidden on xs phones — available in mobile menu instead) --}}
            <form action="{{ route('shop') }}" method="GET"
                  class="hidden sm:flex flex-1 rounded-md overflow-hidden min-w-0 shadow-sm">
                {{-- Category selector (md+) --}}
                <div class="hidden md:flex items-stretch relative flex-shrink-0 max-w-[7rem] bg-gray-200 border-r border-gray-300">
                    <select name="category"
                        class="appearance-none h-full w-full bg-transparent text-gray-700 text-xs pl-2 pr-5 focus:outline-none cursor-pointer">
                        <option value="">All</option>
                        @foreach(\App\Models\Category::where('status', true)->orderBy('sort_order')->get() as $scat)
                            <option value="{{ $scat->slug }}" {{ request('category') === $scat->slug ? 'selected' : '' }}>
                                {{ Str::limit($scat->name, 18) }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Search products, brands, categories..."
                    class="flex-1 px-3 py-2.5 text-gray-800 text-sm focus:outline-none bg-white min-w-0" />
                <button type="submit"
                    class="bg-accent hover:bg-accent-dark px-3 sm:px-4 flex items-center justify-center flex-shrink-0 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>

            {{-- Right action group --}}
            <div class="flex items-center flex-shrink-0 gap-0.5 ml-auto">

                @auth
                    {{-- Account dropdown --}}
                    <div class="relative" x-data="{ open: false }" x-on:app:before-navigate.window="open = false">
                        <button @click="open = !open"
                            class="hidden sm:flex flex-col leading-tight px-2 py-1 border border-transparent hover:border-white/60 rounded text-left">
                            <span class="text-xs text-gray-300 whitespace-nowrap">Hello, {{ Str::limit(auth()->user()->name, 12) }}</span>
                            <span class="text-xs font-bold whitespace-nowrap flex items-center gap-0.5">
                                Account
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </span>
                        </button>
                        <div x-show="open" @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-xl shadow-2xl border border-gray-100 py-1.5 z-50">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-gray-50 text-brand font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                                    Admin Panel
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                            @endif
                            <a href="{{ route('account.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-gray-50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                My Account
                            </a>
                            <a href="{{ route('account.orders') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-gray-50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                My Orders
                            </a>
                            <a href="{{ route('account.wishlist') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-gray-50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                Wishlist
                            </a>
                            <a href="{{ route('account.profile') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-gray-50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Settings
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Returns & Orders (lg+) --}}
                    <a href="{{ route('account.orders') }}"
                       class="hidden lg:flex flex-col leading-tight px-2 py-1 border border-transparent hover:border-white/60 rounded">
                        <span class="text-xs text-gray-300">Returns &amp;</span>
                        <span class="text-xs font-bold">Orders</span>
                    </a>

                    {{-- Wishlist --}}
                    <a href="{{ route('account.wishlist') }}"
                       class="flex items-center px-2 py-1 border border-transparent hover:border-white/60 rounded">
                        <div class="relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="wishlist-count absolute -top-1 -right-1 bg-accent text-white text-xs min-w-[1.15rem] h-[1.15rem] px-0.5 rounded-full flex items-center justify-center font-bold leading-none {{ ($wishlistCount ?? 0) == 0 ? 'hidden' : '' }}">
                                {{ $wishlistCount ?? 0 }}
                            </span>
                        </div>
                    </a>

                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:flex flex-col leading-tight px-2 py-1 border border-transparent hover:border-white/60 rounded">
                        <span class="text-xs text-gray-300 whitespace-nowrap">Hello, sign in</span>
                        <span class="text-xs font-bold whitespace-nowrap flex items-center gap-0.5">
                            Account &amp; Lists
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden sm:block text-xs font-semibold px-3 py-1.5 border border-white/40 rounded hover:bg-white/10 transition-colors whitespace-nowrap ml-1">
                        Register
                    </a>
                @endauth

                {{-- Cart --}}
                <a href="{{ route('cart') }}"
                   class="flex items-end gap-1 px-2 py-1 border border-transparent hover:border-white/60 rounded ml-1">
                    <div class="relative">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="cart-count absolute -top-1 -right-1 bg-accent text-white text-xs min-w-[1.15rem] h-[1.15rem] px-0.5 rounded-full flex items-center justify-center font-bold leading-none {{ ($cartCount ?? 0) == 0 ? 'hidden' : '' }}">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </div>
                </a>

                {{-- Mobile menu toggle --}}
                <button @click="mobileOpen = !mobileOpen"
                    class="sm:hidden p-2 border border-transparent hover:border-white/60 rounded ml-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Row 2: Category nav bar (hidden on mobile — menu is in hamburger) ── --}}
    <nav class="hidden sm:block bg-brand border-t border-white/10">
        {{-- "All" dropdown is OUTSIDE the overflow-x-auto container so it isn't clipped --}}
        <div class="max-w-screen-2xl mx-auto px-3 sm:px-4 flex items-center">

            <div class="relative flex-shrink-0" x-data="{ open: false }" x-on:app:before-navigate.window="open = false">
                <button @click="open = !open"
                    class="flex items-center gap-1.5 px-3 py-2.5 text-sm font-bold hover:bg-white/15 rounded-sm whitespace-nowrap border-r border-white/20 mr-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    All
                </button>
                <div x-show="open" @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 mt-0.5 w-64 bg-white text-gray-800 rounded-xl shadow-2xl border border-gray-100 py-2 z-[60] max-h-96 overflow-y-auto">
                    @foreach(\App\Models\Category::where('status', true)->orderBy('sort_order')->get() as $navCat)
                        <a href="{{ route('shop.category', $navCat->slug) }}"
                           class="flex items-center justify-between px-4 py-2.5 text-sm hover:bg-gray-50 hover:text-brand transition-colors group">
                            <span>{{ $navCat->name }}</span>
                            <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Scrollable nav links --}}
            <div class="flex items-center overflow-x-auto hide-scrollbar flex-1 min-w-0">
                <a href="{{ route('home') }}"
                   class="px-3 py-2.5 text-sm hover:bg-white/15 rounded-sm whitespace-nowrap flex-shrink-0 transition-colors {{ request()->routeIs('home') ? 'font-bold bg-white/10' : '' }}">
                    Home
                </a>
                <a href="{{ route('shop') }}?sort=latest"
                   class="px-3 py-2.5 text-sm hover:bg-white/15 rounded-sm whitespace-nowrap flex-shrink-0 transition-colors">
                    New Arrivals
                </a>
                <a href="{{ route('shop') }}?featured=1"
                   class="px-3 py-2.5 text-sm hover:bg-white/15 rounded-sm whitespace-nowrap flex-shrink-0 transition-colors">
                    Featured
                </a>
                <a href="{{ route('shop') }}"
                   class="px-3 py-2.5 text-sm hover:bg-white/15 rounded-sm whitespace-nowrap flex-shrink-0 transition-colors {{ request()->routeIs('shop') && !request()->has('sort') && !request()->has('featured') ? 'font-bold bg-white/10' : '' }}">
                    All Products
                </a>
                <a href="{{ route('about') }}"
                   class="px-3 py-2.5 text-sm hover:bg-white/15 rounded-sm whitespace-nowrap flex-shrink-0 transition-colors">
                    About
                </a>
                <a href="{{ route('contact') }}"
                   class="px-3 py-2.5 text-sm hover:bg-white/15 rounded-sm whitespace-nowrap flex-shrink-0 transition-colors">
                    Contact
                </a>
                <a href="{{ route('services') }}"
                   class="px-3 py-2.5 text-sm hover:bg-white/15 rounded-sm whitespace-nowrap flex-shrink-0 transition-colors {{ request()->routeIs('services') ? 'font-bold bg-white/10' : '' }}">
                    Services &amp; Pricing
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-3 py-2.5 text-sm hover:bg-white/15 rounded-sm whitespace-nowrap flex-shrink-0 transition-colors text-yellow-300 font-semibold ml-auto">
                            Admin Panel
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    {{-- ── Mobile menu ──────────────────────────────────────────── --}}
    <div x-show="mobileOpen"
         @click.outside="mobileOpen = false"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="sm:hidden border-t border-white/10 bg-brand-dark max-h-[80vh] overflow-y-auto">
        <div class="px-4 py-3">

            {{-- Search --}}
            <form action="{{ route('shop') }}" method="GET" class="flex rounded-lg overflow-hidden mb-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                    class="flex-1 px-3 py-2.5 text-gray-800 text-sm focus:outline-none" />
                <button type="submit" class="bg-accent px-4 flex items-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>

            {{-- Navigation --}}
            <p class="text-xs font-bold uppercase tracking-widest text-blue-300 px-1 mb-1.5">Navigation</p>
            <div class="space-y-0.5 mb-4">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors {{ request()->routeIs('home') ? 'bg-white/10 font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Home
                </a>
                <a href="{{ route('shop') }}"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    All Products
                </a>
                <a href="{{ route('shop') }}?sort=latest"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    New Arrivals
                </a>
                <a href="{{ route('shop') }}?featured=1"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Featured
                </a>
                <a href="{{ route('about') }}"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    About
                </a>
                <a href="{{ route('contact') }}"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Contact
                </a>
                <a href="{{ route('services') }}"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors {{ request()->routeIs('services') ? 'bg-white/10 font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Services &amp; Pricing
                </a>
            </div>

            {{-- Categories --}}
            <p class="text-xs font-bold uppercase tracking-widest text-blue-300 px-1 mb-1.5">Categories</p>
            <div class="space-y-0.5 mb-4">
                @foreach(\App\Models\Category::where('status', true)->orderBy('sort_order')->take(7)->get() as $mcat)
                    <a href="{{ route('shop.category', $mcat->slug) }}"
                       class="flex items-center gap-3 py-2 px-3 rounded-lg text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        {{ $mcat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Account --}}
            <p class="text-xs font-bold uppercase tracking-widest text-blue-300 px-1 mb-1.5">Account</p>
            <div class="space-y-0.5 pb-2">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm text-yellow-300 font-semibold hover:bg-white/10 transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                            </svg>
                            Admin Panel
                        </a>
                    @endif
                    <a href="{{ route('account.dashboard') }}"
                       class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        My Account
                    </a>
                    <a href="{{ route('account.orders') }}"
                       class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        My Orders
                    </a>
                    <a href="{{ route('account.wishlist') }}"
                       class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Wishlist
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm text-red-400 hover:bg-white/10 transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Create Account
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- ════════════════════════════════════════════════════════════
     FLASH MESSAGES
════════════════════════════════════════════════════════════ --}}
@if(session('success') || session('error'))
    <div class="fixed top-20 right-4 z-50 max-w-sm space-y-2">
        @if(session('success'))
            <div class="alert-success shadow-lg">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error shadow-lg">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif

{{-- ════════════════════════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════════════════════════ --}}
<main class="min-h-screen">
    @yield('content')
</main>

{{-- ════════════════════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════════════════ --}}
<footer class="bg-brand-dark text-white">

    {{-- Back to top --}}
    <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="w-full bg-brand/50 hover:bg-brand/70 text-white text-sm py-3 text-center transition-colors border-b border-white/10">
        Back to top
    </button>

    {{-- Footer columns --}}
    <div class="max-w-screen-2xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">

            {{-- Brand info --}}
            <div class="col-span-2 md:col-span-1">
                <img src="{{ asset('images/ttsolutions_logo.png') }}" alt="TTSolutions Limited"
                     class="w-auto object-contain mb-4" style="height: 51px;">
                <p class="text-gray-400 text-sm leading-relaxed mb-4">
                    Transforming Ideas into Powerful Digital Solutions Across Papua New Guinea.
                </p>
                <div class="space-y-1.5">
                    <a href="tel:+67572243900" class="flex items-center gap-2 text-xs text-gray-400 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +675 7224 3900
                    </a>
                    <a href="mailto:ttsl.support@gmail.com" class="flex items-center gap-2 text-xs text-gray-400 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        ttsl.support@gmail.com
                    </a>
                    <a href="https://www.ttsolutionspng.com" target="_blank" rel="noopener" class="flex items-center gap-2 text-xs text-gray-400 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        www.ttsolutionspng.com
                    </a>
                </div>
            </div>

            {{-- Shop --}}
            <div>
                <h4 class="font-semibold text-sm mb-4 uppercase tracking-wider text-white">Shop</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('shop') }}" class="hover:text-white transition-colors">All Products</a></li>
                    <li><a href="{{ route('shop') }}?sort=latest" class="hover:text-white transition-colors">New Arrivals</a></li>
                    <li><a href="{{ route('shop') }}?featured=1" class="hover:text-white transition-colors">Featured Items</a></li>
                    @foreach(\App\Models\Category::where('status', true)->orderBy('sort_order')->take(5)->get() as $fcat)
                        <li><a href="{{ route('shop.category', $fcat->slug) }}" class="hover:text-white transition-colors">{{ $fcat->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Customer Service --}}
            <div>
                <h4 class="font-semibold text-sm mb-4 uppercase tracking-wider text-white">Customer Service</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    @auth
                        <li><a href="{{ route('account.dashboard') }}" class="hover:text-white transition-colors">My Account</a></li>
                        <li><a href="{{ route('account.orders') }}" class="hover:text-white transition-colors">Track Order</a></li>
                        <li><a href="{{ route('account.wishlist') }}" class="hover:text-white transition-colors">My Wishlist</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Create Account</a></li>
                    @endauth
                    <li><a href="{{ route('cart') }}" class="hover:text-white transition-colors">Shopping Cart</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors">FAQs</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Support</a></li>
                </ul>
            </div>

            {{-- Company --}}
            <div>
                <h4 class="font-semibold text-sm mb-4 uppercase tracking-wider text-white">Company</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-white transition-colors">Services &amp; Pricing</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors">FAQs</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-screen-2xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
            <span>&copy; {{ date('Y') }} TTSolutions Limited (TTSL). All rights reserved.</span>
            <div class="hidden sm:flex items-center gap-1">
                <img src="{{ asset('images/ttsolutions_logo.png') }}" alt="" class="w-auto opacity-70" style="height: 21px;">
                <span>TTSolutions Limited &mdash; Keeping You Connected.</span>
            </div>
        </div>
    </div>
</footer>

@include('components.save-man-widget')
@include('components.cookie-consent')
@stack('scripts')
</body>
</html>
