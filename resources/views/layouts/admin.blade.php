<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Admin') | TTSL Store Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen" x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    init() {
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) this.sidebarOpen = true;
        });
    }
}">

@include('components.page-loader')

<div class="flex min-h-screen">

    {{-- Mobile overlay: close sidebar when tapping outside --}}
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display:none;">
    </div>

    {{-- Sidebar --}}
    <aside class="w-64 bg-brand-dark text-white flex flex-col flex-shrink-0 fixed inset-y-0 z-50 transition-transform"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="p-4 border-b border-white/10">
            <img src="{{ asset('images/Logo_white.png') }}" alt="TTSolutions Limited" class="w-auto object-contain" style="height: 46px;">
            <div class="text-xs text-blue-300 mt-1 pl-0.5">Admin Panel</div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <div class="pt-3 pb-1">
                <p class="text-xs text-blue-300 uppercase tracking-wider px-4">Catalogue</p>
            </div>
            <a href="{{ route('admin.products.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Products
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Categories
            </a>
            <a href="{{ route('admin.brands.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                DevTools
            </a>
            <a href="{{ route('admin.features.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.features.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                Add-on Features
            </a>

            <div class="pt-3 pb-1">
                <p class="text-xs text-blue-300 uppercase tracking-wider px-4">Storefront</p>
            </div>
            <a href="{{ route('admin.hero-slides.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Hero Slides
            </a>

            <div class="pt-3 pb-1">
                <p class="text-xs text-blue-300 uppercase tracking-wider px-4">Sales</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="flex-1">Orders</span>
                <span id="badge-orders" class="hidden ml-auto text-xs font-bold bg-red-500 text-white rounded-full min-w-[1.25rem] h-5 px-1.5 inline-flex items-center justify-center leading-none flex-shrink-0"></span>
            </a>
            <a href="{{ route('admin.customers.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="flex-1">Customers</span>
                <span id="badge-customers" class="hidden ml-auto text-xs font-bold bg-green-500 text-white rounded-full min-w-[1.25rem] h-5 px-1.5 inline-flex items-center justify-center leading-none flex-shrink-0"></span>
            </a>

            <div class="pt-3 pb-1">
                <p class="text-xs text-blue-300 uppercase tracking-wider px-4">Reports</p>
            </div>
            <a href="{{ route('admin.reports.sales') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Sales Report
            </a>
            <a href="{{ route('admin.reports.products') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.reports.products') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Product Report
            </a>
            <a href="{{ route('admin.reports.inventory') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <span class="flex-1">Inventory</span>
                <span id="badge-inventory" class="hidden ml-auto text-xs font-bold bg-amber-500 text-white rounded-full min-w-[1.25rem] h-5 px-1.5 inline-flex items-center justify-center leading-none flex-shrink-0"></span>
            </a>
            <a href="{{ route('admin.reports.customers') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.reports.customers') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Customer Report
            </a>

            <div class="pt-3 pb-1">
                <p class="text-xs text-blue-300 uppercase tracking-wider px-4">System</p>
            </div>
            <a href="{{ route('admin.settings.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>
        </nav>

        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-medium truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-blue-200 capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</div>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('home') }}" class="flex-1 flex items-center justify-center gap-1 text-xs text-blue-200 hover:text-white py-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Store
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-1 text-xs text-blue-200 hover:text-white py-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col ml-0 lg:ml-64 transition-all duration-300 min-w-0">
        {{-- Top bar --}}
        <header class="bg-white shadow-sm px-4 sm:px-6 py-4 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-3 min-w-0">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="flex-shrink-0 p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg sm:text-xl font-semibold text-gray-800 truncate">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="text-xs sm:text-sm text-gray-500 flex-shrink-0 ml-2">{{ now()->format('d M Y') }}</div>
        </header>

        {{-- Flash --}}
        @if(session('success') || session('error'))
            <div class="mx-3 sm:mx-6 mt-4 flash-message">
                @if(session('success'))
                    <div class="alert-success flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert-error flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <main class="flex-1 p-3 sm:p-6">
            @yield('content')
        </main>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     GLOBAL CONFIRMATION MODAL
══════════════════════════════════════════════════════════ --}}
<script>
function confirmModal() {
    return {
        show: false,
        title: 'Confirm Action',
        message: 'Are you sure you want to continue?',
        pendingCallback: null,
        open(detail) {
            this.title           = detail.title    || 'Confirm Action';
            this.message         = detail.message  || 'Are you sure you want to continue? This action cannot be undone.';
            this.pendingCallback = detail.callback || null;
            this.show = true;
        },
        proceed() {
            var cb = this.pendingCallback;
            this.pendingCallback = null;
            this.show = false;
            if (typeof cb === 'function') cb();
        },
        cancel() {
            this.pendingCallback = null;
            this.show = false;
        }
    };
}

function askConfirm(message, callback, title) {
    window.dispatchEvent(new CustomEvent('confirm-action', {
        detail: {
            title:    title    || 'Confirm Action',
            message:  message  || 'Are you sure you want to continue?',
            callback: callback || null
        }
    }));
}

function askConfirmForm(event, message, title) {
    event.preventDefault();
    var form = event.target;
    askConfirm(message, function () { form.submit(); }, title || 'Confirm Action');
    return false;
}
</script>

<div x-data="confirmModal()"
     x-on:confirm-action.window="open($event.detail)"
     x-show="show"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[200] flex items-center justify-center p-4"
     style="display:none;">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="cancel()"></div>

    {{-- Modal card --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 overflow-hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-2">

        {{-- Red accent bar --}}
        <div class="h-1.5 bg-gradient-to-r from-red-500 to-red-700"></div>

        <div class="p-6">
            {{-- Warning icon --}}
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mx-auto mb-4">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            {{-- Title --}}
            <h3 class="text-lg font-bold text-gray-900 text-center mb-1.5" x-text="title"></h3>

            {{-- Message --}}
            <p class="text-sm text-gray-500 text-center leading-relaxed mb-6" x-text="message"></p>

            {{-- Buttons --}}
            <div class="flex gap-3">
                <button @click="cancel()"
                        class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button @click="proceed()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white font-semibold text-sm hover:bg-red-700 active:bg-red-800 transition-colors focus:outline-none focus:ring-2 focus:ring-red-400">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SIDEBAR LIVE BADGE POLLING
══════════════════════════════════════════════════════════ --}}
<script>
(function () {
    var POLL_MS = 30000;

    function setBadge(id, count) {
        var el = document.getElementById(id);
        if (!el) return;
        if (count > 0) {
            el.textContent = count > 99 ? '99+' : count;
            el.classList.remove('hidden');
        } else {
            el.classList.add('hidden');
        }
    }

    function fetchBadges() {
        fetch('{{ route('admin.badges') }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin'
        })
        .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
        .then(function (data) {
            setBadge('badge-orders',    data.orders    || 0);
            setBadge('badge-customers', data.customers || 0);
            setBadge('badge-inventory', (data.inventory || 0) + (data.out_of_stock || 0));
        })
        .catch(function () {});
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchBadges();
        setInterval(fetchBadges, POLL_MS);
    });
})();
</script>

@stack('scripts')
</body>
</html>
