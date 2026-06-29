@extends('layouts.app')
@section('title', 'Terms and Conditions')

@section('content')

<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold">Terms and Conditions</h1>
        <p class="text-blue-100 mt-2">TTSolutions Limited (TTSL) &mdash; Effective from 19 September 2025</p>
    </div>
</div>

<div class="container mx-auto px-4 py-16 max-w-4xl">
    <div class="card p-8 md:p-12 space-y-10">

        <p class="text-gray-600 leading-relaxed">
            By accessing, browsing, purchasing, or using any products, services, software, systems, websites, or platforms provided by <strong>TTSolutions Limited (TTSL)</strong>, you agree to be bound by these Terms and Conditions.
        </p>

        {{-- Section 1 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">1</span>
                Acceptance of Terms
            </h2>
            <p class="text-gray-600 leading-relaxed">
                By accessing, browsing, purchasing, or using any products, services, software, systems, websites, or platforms provided by TTSolutions Limited (TTSL), you agree to be bound by these Terms and Conditions.
            </p>
        </section>

        {{-- Section 2 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">2</span>
                Services
            </h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                TTSL provides software development, website development, cloud hosting, ICT consulting, technical support, digital transformation services, and related technology solutions.
            </p>
            <p class="text-gray-600 leading-relaxed">
                The scope of services for each project shall be defined in the agreed proposal, quotation, contract, or service agreement.
            </p>
        </section>

        {{-- Section 3 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">3</span>
                Project Engagement
            </h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                Clients must provide accurate and complete information necessary for project implementation.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Any additional requirements requested after project commencement may result in revised timelines, additional costs, or contract amendments.
            </p>
        </section>

        {{-- Section 4 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">4</span>
                Payments
            </h2>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>All services are subject to agreed pricing and payment terms.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Payments made for completed work are non-refundable unless otherwise specified in a written agreement.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>TTSL reserves the right to suspend services where invoices remain unpaid beyond agreed payment terms.</li>
            </ul>
        </section>

        {{-- Section 5 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">5</span>
                Intellectual Property
            </h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                Upon full payment, ownership of custom-developed software, websites, and systems may be transferred to the client as specified in the project agreement.
            </p>
            <p class="text-gray-600 leading-relaxed">
                TTSL retains ownership of proprietary frameworks, libraries, methodologies, templates, and technologies developed independently by the company.
            </p>
        </section>

        {{-- Section 6 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">6</span>
                Hosting and Support Services
            </h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                Hosting and support services are provided under applicable service agreements.
            </p>
            <p class="text-gray-600 leading-relaxed">
                TTSL will make reasonable efforts to ensure service availability but does not guarantee uninterrupted operation due to circumstances beyond our control.
            </p>
        </section>

        {{-- Section 7 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">7</span>
                Client Responsibilities
            </h2>
            <p class="text-gray-600 leading-relaxed mb-3">Clients are responsible for:</p>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Maintaining the confidentiality of account credentials.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Providing accurate project requirements.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Ensuring lawful use of provided services.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Backing up critical data where applicable.</li>
            </ul>
        </section>

        {{-- Section 8 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">8</span>
                Prohibited Activities
            </h2>
            <p class="text-gray-600 leading-relaxed mb-3">Users must not use TTSL services for:</p>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Illegal activities.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Fraudulent transactions.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Distribution of malware or harmful content.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Unauthorized access to systems or networks.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Activities that violate Papua New Guinea laws or international regulations.</li>
            </ul>
        </section>

        {{-- Section 9 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">9</span>
                Limitation of Liability
            </h2>
            <p class="text-gray-600 leading-relaxed">
                TTSL shall not be liable for indirect, incidental, consequential, or special damages arising from the use or inability to use our services.
            </p>
        </section>

        {{-- Section 10 --}}
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">10</span>
                Amendments
            </h2>
            <p class="text-gray-600 leading-relaxed">
                TTSL reserves the right to update these Terms and Conditions at any time. Updated terms will be published on our website and become effective upon publication.
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
                    <a href="{{ route('privacy') }}" class="btn-secondary text-sm">Privacy Policy</a>
                    <a href="{{ route('contact') }}" class="btn-primary text-sm">Contact Us</a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
