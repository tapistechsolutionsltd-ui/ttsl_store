@extends('layouts.app')
@section('title', 'FAQ')

@section('content')
<div class="page-header"><div class="container mx-auto px-4"><h1 class="text-4xl font-bold">Frequently Asked Questions</h1><p class="text-blue-100 mt-2">Everything you need to know about our digital services</p></div></div>
<div class="container mx-auto px-4 py-16 max-w-3xl">
    @php
    $faqs = [
        'Our Services' => [
            ['q' => 'What services does TTSolutions offer?',
             'a' => 'TTSolutions Limited (TTSL) offers a comprehensive range of digital and ICT services, including professional website design and development, domain name registration, web hosting, social media management, custom e-commerce stores, business branding, and ICT infrastructure solutions for businesses and organisations across Papua New Guinea.'],
            ['q' => 'What is included in a website package?',
             'a' => 'Our website packages include custom design and development, mobile-responsive layout, basic SEO setup, contact form integration, and a full project handover with documentation. Features such as e-commerce functionality, booking systems, or custom databases are available as add-ons or in higher-tier packages. Visit our Services & Pricing page for full details.'],
            ['q' => 'Do you offer domain registration and web hosting?',
             'a' => 'Yes. We offer domain registration and managed web hosting as standalone services or bundled within a full website package. We support .com, .com.pg, and other popular domain extensions.'],
            ['q' => 'Can TTSolutions manage my social media pages?',
             'a' => 'Yes. Our social media management service includes profile setup and branding, regular content creation and posting, audience engagement, and basic analytics reporting. Plans are available on a monthly basis.'],
        ],
        'Orders & Projects' => [
            ['q' => 'How do I place an order?',
             'a' => 'Browse our Services & Pricing page, add the services you need to your cart, and complete the checkout process. You will be asked to provide your contact details, project information, and any relevant files (such as your logo or reference materials). Once your order is submitted, our team will review it and contact you within 1–2 business days to confirm and begin work.'],
            ['q' => 'How long does it take to build my website?',
             'a' => 'Project timelines depend on the complexity and scope of work. A standard business website typically takes 7–21 business days from the time the project brief and 50% deposit are received. More complex projects such as e-commerce stores or custom applications may take longer. Estimated timelines are listed in each service description.'],
            ['q' => 'Can I request changes or revisions during development?',
             'a' => 'Yes. Each package includes a set number of revision rounds as outlined in our Terms of Service. We work closely with every client throughout the process to ensure the final product meets your expectations. Additional revisions beyond the included allowance may be subject to a fee.'],
            ['q' => 'Can I cancel or modify my order after placing it?',
             'a' => 'Order modifications can be requested within 24 hours of placement, provided work has not yet commenced. Once a project is underway, cancellations are subject to our refund policy as outlined in the Terms of Service. Deposits paid for work already in progress are generally non-refundable.'],
        ],
        'Payments' => [
            ['q' => 'What payment methods do you accept?',
             'a' => 'We accept direct bank transfers via BSP (Bank South Pacific) and Kina Bank. A 50% deposit is required upfront before any project begins, with the remaining balance due upon completion and handover. Cash payments can also be arranged for clients in Port Moresby.'],
            ['q' => 'Is a deposit required before work begins?',
             'a' => 'Yes. A 50% deposit of the total project cost is required before work can commence. This ensures commitment from both parties and allows us to allocate the necessary resources to your project. The remaining 50% is invoiced upon project completion.'],
            ['q' => 'Why is a personal bank account used for transactions?',
             'a' => 'Our business banking account is currently being finalised through the registration process. In the meantime, all payments are processed via a verified personal account held by our authorised representative. This is a temporary arrangement, and we will transition to our business account upon completion. Please do not hesitate to contact us if you have any questions or concerns regarding this.'],
            ['q' => 'Is my payment information secure?',
             'a' => 'Yes. All bank transfers are made directly to our verified account. We do not collect or store any card numbers or banking credentials on our platform. All payments are fully traceable and receipts are available upon request.'],
        ],
        'Account & Privacy' => [
            ['q' => 'Is my personal information safe with TTSolutions?',
             'a' => 'Absolutely. We are committed to protecting your personal information and maintaining your privacy. Your data is collected and used solely for the purpose of processing your order and communicating project progress. We do not share your information with third parties without your explicit consent. Please review our Privacy Policy for full details.'],
            ['q' => 'What data do you collect when I place an order?',
             'a' => 'When placing an order, we collect your name, email address, phone number, company name (if applicable), and project details. This information is used exclusively to manage your order and deliver our services. You may request access to or deletion of your data at any time by contacting us at ttsl.support@gmail.com.'],
            ['q' => 'Do I need an account to place an order?',
             'a' => 'Yes. A free account is required to place an order. This allows you to track your project status in real time, view your full order history, download project documents, and communicate directly with our team through your personal client dashboard.'],
        ],
        'Technical Support' => [
            ['q' => 'What post-delivery support do you offer?',
             'a' => 'After your project is completed and handed over, we provide a post-delivery support period (as specified in your package) during which any reported bugs or issues are corrected at no additional cost. Ongoing maintenance and update plans are available beyond the initial support window.'],
            ['q' => 'Do you provide training after the website is delivered?',
             'a' => 'Yes. For content-managed websites (such as WordPress), we provide basic walkthrough training so you can update content, add posts, and manage your site independently. Training can be conducted in person for Port Moresby clients or delivered via a recorded video guide.'],
            ['q' => 'What if I need help after my support period ends?',
             'a' => 'We offer ongoing support and maintenance retainer packages for clients who require regular updates or technical assistance after the initial support period. You are also welcome to contact us at any time for ad-hoc support — our team is available via phone and email during business hours.'],
        ],
    ];
    @endphp

    @foreach($faqs as $section => $questions)
        <div class="mb-10" x-data="{}">
            <h2 class="text-xl font-bold text-brand mb-4 flex items-center gap-2">
                @switch($section)
                    @case('Our Services')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @break
                    @case('Orders & Projects')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        @break
                    @case('Payments')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        @break
                    @case('Account & Privacy')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        @break
                    @case('Technical Support')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        @break
                @endswitch
                {{ $section }}
            </h2>
            <div class="space-y-3">
                @foreach($questions as $faq)
                    <div class="card" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full text-left px-5 py-4 flex items-center justify-between font-medium text-gray-800 hover:text-brand transition-colors">
                            {{ $faq['q'] }}
                            <svg class="w-5 h-5 flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-5 pb-4 text-gray-600 leading-relaxed">{{ $faq['a'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="card p-6 text-center mt-6 bg-blue-50 border border-blue-100">
        <h3 class="font-bold text-lg text-gray-800 mb-2">Still have questions?</h3>
        <p class="text-gray-500 mb-4">Our team is available to help you with anything not covered above.</p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('contact') }}" class="btn-primary">Contact Us</a>
            <a href="{{ route('services') }}" class="btn-secondary">View Services &amp; Pricing</a>
            <a href="tel:+67572243900" class="btn-secondary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Call Us
            </a>
        </div>
    </div>
</div>
@endsection
