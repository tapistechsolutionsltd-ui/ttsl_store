@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('content')

<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold">Privacy Policy</h1>
        <p class="text-blue-100 mt-2">TTSolutions Limited (TTSL) &mdash; Effective from 19 September 2025</p>
    </div>
</div>

<div class="container mx-auto px-4 py-16 max-w-4xl">
    <div class="card p-8 md:p-12 space-y-10">

        {{-- Introduction --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Introduction</h2>
            <p class="text-gray-600 leading-relaxed">
                TTSolutions Limited (TTSL) respects your privacy and is committed to protecting your personal and business information. This Privacy Policy explains how we collect, use, store, and protect information obtained through our website, systems, applications, and services.
            </p>
        </section>

        {{-- Information We Collect --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-4">Information We Collect</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-xl p-5">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Personal Information
                    </h3>
                    <ul class="space-y-1.5 text-gray-600 text-sm">
                        <li>Full Name</li>
                        <li>Email Address</li>
                        <li>Phone Number</li>
                        <li>Company Name</li>
                        <li>Business Address</li>
                    </ul>
                </div>
                <div class="bg-gray-50 rounded-xl p-5">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/></svg>
                        Technical Information
                    </h3>
                    <ul class="space-y-1.5 text-gray-600 text-sm">
                        <li>IP Address</li>
                        <li>Browser Type</li>
                        <li>Device Information</li>
                        <li>Website Usage Data</li>
                        <li>Cookies &amp; Analytics</li>
                    </ul>
                </div>
                <div class="bg-gray-50 rounded-xl p-5">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Project Information
                    </h3>
                    <ul class="space-y-1.5 text-gray-600 text-sm">
                        <li>Business Requirements</li>
                        <li>Documents Provided</li>
                        <li>System Configuration</li>
                        <li>Support Requests</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- How We Use Information --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">How We Use Information</h2>
            <p class="text-gray-600 leading-relaxed mb-3">We use collected information to:</p>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Deliver requested services.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Develop and maintain software solutions.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Process inquiries and quotations.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Provide customer support.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Improve service quality.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Enhance system security.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Comply with legal obligations.</li>
            </ul>
        </section>

        {{-- Information Sharing --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Information Sharing</h2>
            <p class="text-gray-600 leading-relaxed mb-3">
                TTSL does not sell, rent, or trade personal information to third parties. Information may only be shared where:
            </p>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Required by law.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Necessary for service delivery.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Authorized by the client.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Required for payment processing or infrastructure services.</li>
            </ul>
        </section>

        {{-- Data Security --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Data Security</h2>
            <p class="text-gray-600 leading-relaxed">
                We implement reasonable administrative, technical, and physical safeguards to protect personal and business information against unauthorized access, disclosure, alteration, or destruction.
            </p>
        </section>

        {{-- Data Retention --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Data Retention</h2>
            <p class="text-gray-600 leading-relaxed">
                Information is retained only as long as necessary to provide services, comply with legal obligations, and support legitimate business operations.
            </p>
        </section>

        {{-- Cookies --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Cookies</h2>
            <p class="text-gray-600 leading-relaxed">
                Our website may use cookies and similar technologies to improve user experience, analyze website performance, and enhance functionality. Users may disable cookies through their browser settings; however, some website features may be affected.
            </p>
        </section>

        {{-- Third-Party Services --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Third-Party Services</h2>
            <p class="text-gray-600 leading-relaxed">
                Our services may integrate with third-party providers including payment gateways, hosting providers, communication platforms, and cloud infrastructure services. These providers maintain their own privacy policies.
            </p>
        </section>

        {{-- Your Rights --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Your Rights</h2>
            <p class="text-gray-600 leading-relaxed mb-3">You may request:</p>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Access to your personal information.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Correction of inaccurate information.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Deletion of information where legally permissible.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Withdrawal of consent where applicable.</li>
            </ul>
        </section>

        {{-- Changes --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Changes to this Privacy Policy</h2>
            <p class="text-gray-600 leading-relaxed">
                TTSL reserves the right to update this Privacy Policy at any time. Updated versions will be published on our website.
            </p>
        </section>

        <div class="border-t border-gray-200 pt-8">
            <div class="flex flex-wrap gap-4 justify-between items-center">
                <div class="text-sm text-gray-500">
                    <strong>TTSolutions Limited (TTSL)</strong><br>
                    Papua New Guinea<br>
                    Phone: +675 7224 3900 &nbsp;|&nbsp; Email: ttsl.support@gmail.com &nbsp;|&nbsp; <a href="https://www.ttsolutionspng.com" target="_blank" class="hover:text-brand">www.ttsolutionspng.com</a>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('terms') }}" class="btn-secondary text-sm">Terms &amp; Conditions</a>
                    <a href="{{ route('contact') }}" class="btn-primary text-sm">Contact Us</a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
