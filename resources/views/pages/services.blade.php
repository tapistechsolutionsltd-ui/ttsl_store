@extends('layouts.app')
@section('title', 'Development & Hosting Services')

@section('content')

{{-- Hero --}}
<div class="bg-gradient-to-br from-brand-dark via-brand to-brand-dark text-white">
    <div class="max-w-screen-xl mx-auto px-4 py-14 sm:py-20">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-white/60 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                TTSolutions Limited
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold leading-tight mb-4">
                Development, Hosting<br class="hidden sm:block"> &amp; Support Services
            </h1>
            <p class="text-white/70 text-base sm:text-lg leading-relaxed max-w-2xl">
                Professional ICT services for businesses, government agencies, NGOs and schools across Papua New Guinea. We build, host, and support your digital presence from start to finish.
            </p>
            <div class="flex flex-wrap gap-3 mt-8">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 bg-white text-brand font-bold px-6 py-3 rounded-xl text-sm hover:bg-gray-100 transition-colors shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Get a Quote
                </a>
                <a href="{{ route('shop') }}"
                   class="inline-flex items-center gap-2 bg-white/10 border border-white/30 text-white font-semibold px-6 py-3 rounded-xl text-sm hover:bg-white/20 transition-colors">
                    Browse Website Templates
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Quick-jump tabs --}}
<div class="sticky top-14 sm:top-16 z-30 bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-center overflow-x-auto hide-scrollbar gap-1 py-1">
            @foreach([
                ['#web-dev',    'Website Development'],
                ['#sys-dev',    'System Development'],
                ['#charges',    'Default Charges'],
                ['#optional',   'Optional Charges'],
                ['#renewals',   'Annual Renewals'],
                ['#payment',    'Payment Terms'],
                ['#warranty',   'Warranty'],
                ['#ownership',  'Ownership'],
            ] as [$anchor, $label])
            <a href="{{ $anchor }}"
               class="flex-shrink-0 px-3 py-2 text-xs font-semibold text-gray-500 hover:text-brand hover:bg-brand/5 rounded-lg transition-colors whitespace-nowrap">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 py-12 space-y-16">

    {{-- ═══════════════════════════════════════════════════════
         1. WEBSITE DEVELOPMENT
    ═══════════════════════════════════════════════════════ --}}
    <section id="web-dev" class="scroll-mt-28">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 bg-brand/10 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-brand mb-0.5">Section 1</p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Website Development Services</h2>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-10">
            @foreach([
                ['Business Website',     'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['Corporate Website',    'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['E-Commerce Website',   'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                ['Portfolio Website',    'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['School Website',       'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                ['NGO Website',          'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['Government Website',   'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9'],
                ['Custom Solutions',     'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ] as [$name, $icon])
            <div class="bg-white border border-gray-100 rounded-2xl p-4 flex items-center gap-3 shadow-sm hover:shadow-md hover:border-brand/30 transition-all">
                <div class="w-9 h-9 bg-brand/8 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <span class="text-sm font-medium text-gray-700 leading-snug">{{ $name }}</span>
            </div>
            @endforeach
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Standard Package Includes
            </h3>
            <div class="grid sm:grid-cols-2 gap-3">
                @foreach([
                    'Professional Design and Layout',
                    'Mobile Responsive Design',
                    'Content Management System (CMS)',
                    'Contact Forms',
                    'Social Media Integration',
                    'Search Engine Friendly Structure',
                    'SSL Security Configuration',
                    'Basic User Training',
                    'Deployment and Launch Support',
                ] as $item)
                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl">
                    <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-sm text-gray-700">{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         2. SYSTEM DEVELOPMENT
    ═══════════════════════════════════════════════════════ --}}
    <section id="sys-dev" class="scroll-mt-28">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-600 mb-0.5">Section 2</p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Custom System Development</h2>
            </div>
        </div>

        <p class="text-gray-500 mb-8 max-w-2xl">We develop custom systems tailored to your organisation's exact requirements — from small business tools to large-scale government platforms.</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-10">
            @foreach([
                'Government Information Systems',
                'Human Resource Management Systems',
                'Financial Management Systems',
                'Payroll Systems',
                'School Management Systems',
                'Healthcare Management Systems',
                'Property Management Systems',
                'Logistics & Fleet Management Systems',
                'Inventory Management Systems',
                'Customer Relationship Management (CRM)',
                'NGO Management Systems',
                'GIS & Mapping Systems',
                'Document Management Systems',
                'Booking & Reservation Systems',
                'E-Commerce Platforms',
                'SaaS Platforms',
                'Mobile Applications',
                'AI-Powered Solutions',
            ] as $system)
            <div class="flex items-center gap-2.5 p-3 bg-white border border-gray-100 rounded-xl shadow-sm hover:border-indigo-200 hover:shadow-md transition-all">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 flex-shrink-0"></span>
                <span class="text-sm text-gray-700">{{ $system }}</span>
            </div>
            @endforeach
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Development Package Includes
            </h3>
            <div class="grid sm:grid-cols-2 gap-3">
                @foreach([
                    'Requirements Analysis',
                    'System Design',
                    'Database Development',
                    'User Management & Security',
                    'Reporting & Dashboard Modules',
                    'Testing & Quality Assurance',
                    'Deployment & Configuration',
                    'User Training',
                    'Technical Documentation',
                    'Go-Live Support',
                ] as $item)
                <div class="flex items-center gap-3 p-3 bg-indigo-50 rounded-xl">
                    <svg class="w-4 h-4 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-sm text-gray-700">{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         3. DEFAULT CHARGES
    ═══════════════════════════════════════════════════════ --}}
    <section id="charges" class="scroll-mt-28">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-amber-600 mb-0.5">Section 3</p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Charges That Apply by Default</h2>
            </div>
        </div>

        <p class="text-gray-500 mb-8 max-w-2xl">The following charges are normally required for all websites and systems in addition to the development cost.</p>

        <div class="space-y-4">
            @foreach([
                [
                    'title'   => 'Domain Registration',
                    'desc'    => 'Annual registration of a website domain name.',
                    'examples'=> ['company.com', 'company.com.pg', 'company.org'],
                    'billing' => 'Annual Renewal',
                    'icon'    => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9',
                    'color'   => 'blue',
                ],
                [
                    'title'   => 'Website / Server Hosting',
                    'desc'    => 'Secure hosting environment where the website or system operates.',
                    'examples'=> [],
                    'billing' => 'Annual Renewal',
                    'icon'    => 'M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01',
                    'color'   => 'brand',
                ],
                [
                    'title'   => 'SSL Security Certificate',
                    'desc'    => 'Provides secure HTTPS encryption for all visitors.',
                    'examples'=> [],
                    'billing' => 'Included or Annual Renewal depending on package',
                    'icon'    => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                    'color'   => 'green',
                ],
                [
                    'title'   => 'Technical Support & Maintenance',
                    'desc'    => 'System monitoring, updates, troubleshooting, and security maintenance.',
                    'examples'=> [],
                    'billing' => 'Monthly or Annual',
                    'icon'    => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z',
                    'color'   => 'purple',
                ],
                [
                    'title'   => 'Backup Services',
                    'desc'    => 'Regular automated backup of website and system data.',
                    'examples'=> [],
                    'billing' => 'Included or Annual Renewal',
                    'icon'    => 'M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4',
                    'color'   => 'orange',
                ],
            ] as $charge)
            @php
                $colorMap = [
                    'blue'   => ['bg' => 'bg-blue-50',   'icon' => 'text-blue-600',   'border' => 'border-blue-100',   'badge' => 'bg-blue-100 text-blue-700'],
                    'brand'  => ['bg' => 'bg-brand/5',   'icon' => 'text-brand',      'border' => 'border-brand/20',   'badge' => 'bg-brand/10 text-brand'],
                    'green'  => ['bg' => 'bg-green-50',  'icon' => 'text-green-600',  'border' => 'border-green-100',  'badge' => 'bg-green-100 text-green-700'],
                    'purple' => ['bg' => 'bg-purple-50', 'icon' => 'text-purple-600', 'border' => 'border-purple-100', 'badge' => 'bg-purple-100 text-purple-700'],
                    'orange' => ['bg' => 'bg-orange-50', 'icon' => 'text-orange-600', 'border' => 'border-orange-100', 'badge' => 'bg-orange-100 text-orange-700'],
                ];
                $c = $colorMap[$charge['color']];
            @endphp
            <div class="bg-white border {{ $c['border'] }} rounded-2xl p-5 sm:p-6 flex gap-4 items-start shadow-sm">
                <div class="w-10 h-10 {{ $c['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $charge['icon'] }}"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                        <h4 class="font-bold text-gray-900">{{ $charge['title'] }}</h4>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $c['badge'] }}">
                            {{ $charge['billing'] }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">{{ $charge['desc'] }}</p>
                    @if(!empty($charge['examples']))
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($charge['examples'] as $ex)
                                <code class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">{{ $ex }}</code>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         4. OPTIONAL CHARGES
    ═══════════════════════════════════════════════════════ --}}
    <section id="optional" class="scroll-mt-28">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-rose-600 mb-0.5">Section 4</p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Optional Charges</h2>
            </div>
        </div>

        <p class="text-gray-500 mb-8 max-w-2xl">Depending on project requirements, additional charges may apply for the following services:</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach([
                ['SMS Gateway Integration',          'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
                ['Payment Gateway Integration',      'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                ['Mobile Application Development',   'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                ['Cloud Storage Services',           'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'],
                ['API Integrations',                 'M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['AI Services & Automation',         'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['Email Hosting Services',           'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['Data Migration Services',          'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                ['Additional User Training',         'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['Custom Reports & Dashboards',      'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['Multi-Branch Functionality',       'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['GIS Mapping Features',             'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
            ] as [$name, $icon])
            <div class="flex items-center gap-3 p-4 bg-white border border-gray-100 rounded-xl shadow-sm hover:border-rose-200 hover:shadow-md transition-all">
                <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <span class="text-sm text-gray-700">{{ $name }}</span>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         5. ANNUAL RENEWALS
    ═══════════════════════════════════════════════════════ --}}
    <section id="renewals" class="scroll-mt-28">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 bg-teal-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-teal-600 mb-0.5">Section 5</p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Annual Renewals</h2>
            </div>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex gap-3 mb-8">
            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p class="text-sm text-amber-800"><strong>Important:</strong> Failure to renew may result in service interruption or suspension of your website or system.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                'Domain Name Registration',
                'Website Hosting',
                'VPS / Cloud Server Hosting',
                'SSL Certificates (where applicable)',
                'Email Hosting Services',
                'Maintenance & Support Agreements',
            ] as $renewal)
            <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <span class="text-sm font-medium text-gray-700">{{ $renewal }}</span>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         6. PAYMENT TERMS
    ═══════════════════════════════════════════════════════ --}}
    <section id="payment" class="scroll-mt-28">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 bg-brand/10 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-brand mb-0.5">Section 6</p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Payment Terms</h2>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Website projects --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-5">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <h3 class="font-bold text-gray-900">Website Projects</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-14 h-14 bg-brand text-white rounded-xl flex flex-col items-center justify-center flex-shrink-0 font-extrabold leading-none">
                            <span class="text-xl">50%</span>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-gray-900">Deposit</div>
                            <div class="text-xs text-gray-500">Required before commencement</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-14 h-14 bg-green-500 text-white rounded-xl flex flex-col items-center justify-center flex-shrink-0 font-extrabold leading-none">
                            <span class="text-xl">50%</span>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-gray-900">Balance</div>
                            <div class="text-xs text-gray-500">Upon completion, before deployment</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- System projects --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-5">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    <h3 class="font-bold text-gray-900">System Development Projects</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-14 h-14 bg-indigo-600 text-white rounded-xl flex flex-col items-center justify-center flex-shrink-0 font-extrabold leading-none">
                            <span class="text-xl">50%</span>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-gray-900">Deposit</div>
                            <div class="text-xs text-gray-500">Required before commencement</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-14 h-14 bg-purple-500 text-white rounded-xl flex flex-col items-center justify-center flex-shrink-0 font-extrabold leading-none">
                            <span class="text-xl">30%</span>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-gray-900">Milestone Payment</div>
                            <div class="text-xs text-gray-500">Upon development milestone completion</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-14 h-14 bg-green-500 text-white rounded-xl flex flex-col items-center justify-center flex-shrink-0 font-extrabold leading-none">
                            <span class="text-xl">20%</span>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-gray-900">Final Payment</div>
                            <div class="text-xs text-gray-500">Before deployment and handover</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         7, 8, 9 — WARRANTY / OWNERSHIP / DISCLAIMER
    ═══════════════════════════════════════════════════════ --}}
    <div class="grid md:grid-cols-3 gap-6">

        <section id="warranty" class="scroll-mt-28 bg-white border border-green-100 rounded-2xl p-6 shadow-sm">
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-green-600 mb-1">Section 7</p>
            <h3 class="text-lg font-extrabold text-gray-900 mb-4">Support &amp; Warranty</h3>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>30-day warranty on all newly developed websites and systems.</li>
                <li class="flex gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Bug fixes within the original scope are covered during the warranty period.</li>
                <li class="flex gap-2"><svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/></svg>New features after project completion may attract additional charges.</li>
            </ul>
        </section>

        <section id="ownership" class="scroll-mt-28 bg-white border border-brand/20 rounded-2xl p-6 shadow-sm">
            <div class="w-10 h-10 bg-brand/10 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-brand mb-1">Section 8</p>
            <h3 class="text-lg font-extrabold text-gray-900 mb-4">Ownership</h3>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Upon full payment, the client becomes the owner of the completed website or system.</li>
                <li class="flex gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Source code ownership transferred where agreed in the project contract.</li>
                <li class="flex gap-2"><svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/></svg>Third-party and licensed products remain subject to their respective licensing terms.</li>
            </ul>
        </section>

        <section id="disclaimer" class="scroll-mt-28 bg-gray-50 border border-gray-200 rounded-2xl p-6 shadow-sm">
            <div class="w-10 h-10 bg-gray-200 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Section 9</p>
            <h3 class="text-lg font-extrabold text-gray-900 mb-4">Disclaimer</h3>
            <p class="text-sm text-gray-600 leading-relaxed">Project costs vary depending on complexity, features, integrations, number of users, security requirements, and hosting infrastructure. Final pricing will be provided after requirements assessment and approval of project scope.</p>
        </section>
    </div>

    {{-- CTA Banner --}}
    <div class="bg-gradient-to-r from-brand-dark to-brand rounded-2xl p-8 sm:p-10 text-center text-white">
        <h3 class="text-2xl sm:text-3xl font-extrabold mb-3">Ready to Start Your Project?</h3>
        <p class="text-white/70 mb-6 max-w-lg mx-auto">Contact our team today for a free consultation and project quotation tailored to your needs.</p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 bg-white text-brand font-bold px-6 py-3 rounded-xl text-sm hover:bg-gray-100 transition-colors shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Email Us
            </a>
            <a href="tel:+67572243900"
               class="inline-flex items-center gap-2 bg-white/10 border border-white/30 text-white font-semibold px-6 py-3 rounded-xl text-sm hover:bg-white/20 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                +675 7224 3900
            </a>
        </div>
    </div>

</div>
@endsection
