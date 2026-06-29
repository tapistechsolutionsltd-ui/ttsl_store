@extends('layouts.app')
@section('title', 'About Us')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold">About TTSolutions Limited</h1>
        <p class="text-blue-100 mt-2">Papua New Guinea's trusted ICT and digital solutions company</p>
    </div>
</div>

{{-- Who We Are --}}
<div class="container mx-auto px-4 py-16 max-w-5xl">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-16">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Who We Are</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                TTSolutions Limited (TTSL) is a nationally owned Papua New Guinean Information and Communications Technology (ICT) company established on <strong>19 September 2025</strong>. We specialize in the design, development, deployment, hosting, maintenance, and support of innovative digital solutions that empower businesses, government agencies, organizations, and individuals throughout Papua New Guinea and beyond.
            </p>
            <p class="text-gray-600 leading-relaxed mb-6">
                At TTSL, we believe technology should simplify operations, improve efficiency, enhance service delivery, and create opportunities for growth. Our team is committed to delivering reliable, scalable, secure, and cost-effective technology solutions tailored to the unique needs of our clients.
            </p>
            <a href="{{ route('contact') }}" class="btn-primary">Contact Us Today</a>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="card p-5 text-center">
                <div class="text-3xl font-bold text-brand mb-2">2025</div>
                <div class="text-gray-500 text-sm">Established</div>
            </div>
            <div class="card p-5 text-center">
                <div class="text-3xl font-bold text-brand mb-2">PNG</div>
                <div class="text-gray-500 text-sm">Nationally Owned</div>
            </div>
            <div class="card p-5 text-center">
                <div class="text-3xl font-bold text-brand mb-2">ICT</div>
                <div class="text-gray-500 text-sm">Specialists</div>
            </div>
            <div class="card p-5 text-center">
                <div class="text-3xl font-bold text-brand mb-2">24/7</div>
                <div class="text-gray-500 text-sm">Support</div>
            </div>
        </div>
    </div>

    {{-- Services --}}
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">What We Develop & Support</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="card p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                    Digital Products &amp; Platforms
                </h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>CRM &amp; ERP Systems</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>SaaS Platforms</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>E-Commerce &amp; Online Store Solutions</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Corporate &amp; Business Websites</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Payment &amp; SMS Gateway Solutions</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Government Information Management Systems</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Mobile Applications</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Cloud-Based Business Solutions</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Digital Document Management Systems</li>
                </ul>
            </div>
            <div class="card p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Professional ICT Services
                </h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Network Infrastructure Design &amp; Deployment</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>CCTV &amp; Security Surveillance Solutions</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>IT Support &amp; Help Desk Services</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Multimedia &amp; Digital Content Solutions</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>System Integration Services</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Digital Transformation &amp; Digitalization Services</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>ICT Consultancy &amp; Advisory Services</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>Cloud Hosting &amp; Server Management</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Our Aim --}}
    <div class="card p-8 mb-16 border-l-4 border-brand">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Aim</h2>
        <p class="text-gray-600 leading-relaxed">
            Our aim is to contribute meaningfully to Papua New Guinea's digital transformation by providing innovative, affordable, and reliable technology solutions that support the nation's vision of becoming a digitally connected society.
        </p>
        <p class="text-gray-600 leading-relaxed mt-4">
            TTSolutions Limited is committed to supporting Papua New Guinea's <strong>National Digital Transformation Agenda</strong> by enabling government agencies, businesses, educational institutions, and communities to adopt modern digital technologies that improve efficiency, accessibility, transparency, and service delivery. We strive to bridge the technology gap by making advanced digital solutions accessible to organizations of all sizes throughout Papua New Guinea.
        </p>
    </div>

    {{-- Our Goals --}}
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Our Goals</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $goals = [
                ['title' => 'Become PNG\'s Most Reliable Cloud-Based System Developer', 'desc' => 'Establish ourselves as the leading provider of secure, scalable, and dependable cloud-based software solutions throughout Papua New Guinea.'],
                ['title' => 'Drive Digital Transformation', 'desc' => 'Help organizations transition from manual processes to modern digital systems that improve productivity and operational efficiency.'],
                ['title' => 'Deliver Innovative Technology Solutions', 'desc' => 'Continuously develop innovative software products and services that address real-world business and government challenges.'],
                ['title' => 'Support National Development', 'desc' => 'Contribute to the achievement of Papua New Guinea\'s national digital development objectives through technology innovation and capacity building.'],
                ['title' => 'Provide Exceptional Customer Support', 'desc' => 'Deliver continuous technical support, system maintenance, and professional services that ensure long-term customer success.'],
                ['title' => 'Promote Digital Inclusion', 'desc' => 'Make technology accessible and beneficial to organizations and communities across urban and rural Papua New Guinea.'],
                ['title' => 'Maintain Excellence and Integrity', 'desc' => 'Uphold the highest standards of professionalism, quality, security, and ethical business practices in every project we undertake.'],
            ];
            @endphp
            @foreach($goals as $i => $goal)
            <div class="card p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-brand text-white text-sm font-bold flex items-center justify-center flex-shrink-0">{{ $i + 1 }}</div>
                    <h3 class="font-bold text-gray-900 text-sm leading-tight">{{ $goal['title'] }}</h3>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $goal['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="card p-8 bg-brand text-white text-center rounded-2xl">
        <h2 class="text-3xl font-bold mb-4">Ready to Work With Us?</h2>
        <p class="text-blue-100 mb-6">Contact us for enquiries, quotations, or to discuss your digital needs</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="tel:+67572243900" class="bg-white text-brand font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                +675 7224 3900
            </a>
            <a href="mailto:ttsl.support@gmail.com" class="border-2 border-white text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Email Us
            </a>
            <a href="{{ route('contact') }}" class="border-2 border-white/60 text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition-colors">
                Send a Message
            </a>
        </div>
    </div>
</div>

@endsection
