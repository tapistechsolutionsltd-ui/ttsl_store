@extends('layouts.admin')
@section('title', 'System Settings')

@section('content')

{{-- Flash errors --}}
@if(session('mail_error'))
    <div class="alert-error flex items-center gap-2 mb-6">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        {{ session('mail_error') }}
    </div>
@endif

<div x-data="{ tab: '{{ session('active_tab', 'mail') }}' }">

    {{-- Tab Navigation --}}
    <div class="flex gap-1 mb-6 bg-gray-100 p-1 rounded-xl w-fit">
        <button @click="tab = 'mail'"
                :class="tab === 'mail' ? 'bg-white shadow text-brand font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Mail / SMTP
        </button>
        <button @click="tab = 'contact'"
                :class="tab === 'contact' ? 'bg-white shadow text-brand font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            Contact Form
        </button>
        <button @click="tab = 'store'"
                :class="tab === 'store' ? 'bg-white shadow text-brand font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Store Info
        </button>
        <button @click="tab = 'social'"
                :class="tab === 'social' ? 'bg-white shadow text-brand font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Social Login
        </button>
        <button @click="tab = 'orders'"
                :class="tab === 'orders' ? 'bg-white shadow text-brand font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            Order Notifications
        </button>
        <button @click="tab = 'saveman'"
                :class="tab === 'saveman' ? 'bg-white shadow text-brand font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.5 14.5M4.5 14.5l3.097 3.097M14.5 14.5L19.5 14.5M7.5 14.5h9M7.5 17.5h9M12 17.5v3"/>
            </svg>
            Save Man AI
        </button>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TAB 1 — MAIL / SMTP
    ═══════════════════════════════════════════════════════════ --}}
    <div x-show="tab === 'mail'" x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

        <form method="POST" action="{{ route('admin.settings.mail') }}" class="space-y-5">
            @csrf

            {{-- Driver --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    Mail Driver
                </h3>
                <p class="text-xs text-gray-400 mb-4">Choose how outgoing emails are sent. Use <strong>Log</strong> for local testing, <strong>SMTP</strong> for production.</p>

                <div class="grid grid-cols-3 gap-3" x-data="{ driver: '{{ $settings['mail_mailer'] ?? 'log' }}' }">
                    @foreach(['log' => ['Log (Dev)', 'Writes emails to storage/logs — no real sending'], 'smtp' => ['SMTP', 'Sends via external mail server'], 'sendmail' => ['Sendmail', 'Uses the server\'s sendmail binary']] as $val => $info)
                    <label class="flex flex-col gap-1 p-4 border-2 rounded-xl cursor-pointer transition-all"
                           :class="driver === '{{ $val }}' ? 'border-brand bg-brand/5' : 'border-gray-200 hover:border-gray-300'">
                        <input type="radio" name="mail_mailer" value="{{ $val }}"
                               x-model="driver" class="sr-only" />
                        <span class="font-semibold text-sm text-gray-800">{{ $info[0] }}</span>
                        <span class="text-xs text-gray-400 leading-snug">{{ $info[1] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- SMTP Credentials --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    SMTP Server
                </h3>
                <p class="text-xs text-gray-400 mb-5">Required when using the SMTP driver. Leave blank for Log/Sendmail.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Host</label>
                        <input type="text" name="mail_host"
                               value="{{ old('mail_host', $settings['mail_host'] ?? '') }}"
                               class="input-field" placeholder="smtp.mailtrap.io" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Port</label>
                        <input type="number" name="mail_port"
                               value="{{ old('mail_port', $settings['mail_port'] ?? '587') }}"
                               class="input-field" placeholder="587" min="1" max="65535" />
                        <p class="text-xs text-gray-400 mt-1">Common: 587 (TLS) · 465 (SSL) · 25 (plain)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Encryption</label>
                        <select name="mail_encryption" class="input-field">
                            @foreach(['' => 'None', 'tls' => 'TLS (STARTTLS)', 'ssl' => 'SSL'] as $val => $label)
                                <option value="{{ $val }}" {{ ($settings['mail_encryption'] ?? 'tls') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Username</label>
                        <input type="text" name="mail_username"
                               value="{{ old('mail_username', $settings['mail_username'] ?? '') }}"
                               class="input-field" placeholder="your@email.com"
                               autocomplete="new-password" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Password</label>
                        <input type="password" name="mail_password" class="input-field"
                               placeholder="{{ !empty($settings['mail_password']) ? '••••••••  (saved — leave blank to keep)' : 'Enter SMTP password' }}"
                               autocomplete="new-password" />
                        @if(!empty($settings['mail_password']))
                            <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Password is saved and encrypted. Leave blank to keep existing password.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- From Address --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Sender Identity
                </h3>
                <p class="text-xs text-gray-400 mb-5">All system emails will appear to come from this address.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="mail_from_address"
                               value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}"
                               class="input-field" required placeholder="noreply@yourdomain.com" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Name <span class="text-red-500">*</span></label>
                        <input type="text" name="mail_from_name"
                               value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}"
                               class="input-field" required placeholder="Your Store Name" />
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Mail Settings
                </button>
            </div>
        </form>

        {{-- Test Mail --}}
        <div class="card p-6 mt-5 border-l-4 border-blue-400">
            <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Test Mail Connection
            </h3>
            <p class="text-sm text-gray-500 mb-4">Send a test email to verify your SMTP settings are working. Save settings first before testing.</p>
            <form method="POST" action="{{ route('admin.settings.test-mail') }}" class="flex gap-3 items-end">
                @csrf
                <div class="flex-1 max-w-xs">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Send test to</label>
                    <input type="email" name="test_email"
                           value="{{ old('test_email', $settings['mail_from_address'] ?? auth()->user()->email) }}"
                           class="input-field" placeholder="your@email.com" required />
                </div>
                <button type="submit" class="btn-secondary btn-sm flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Send Test Email
                </button>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TAB 2 — CONTACT FORM
    ═══════════════════════════════════════════════════════════ --}}
    <div x-show="tab === 'contact'" x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

        <form method="POST" action="{{ route('admin.settings.contact') }}" class="space-y-5">
            @csrf

            {{-- Routing --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Routing
                </h3>
                <p class="text-xs text-gray-400 mb-5">When a visitor submits the contact form, their message is sent to the address(es) below.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Recipient Email <span class="text-red-500">*</span></label>
                        <input type="email" name="contact_recipient_email"
                               value="{{ old('contact_recipient_email', $settings['contact_recipient_email'] ?? '') }}"
                               class="input-field" required placeholder="support@yourdomain.com" />
                        <p class="text-xs text-gray-400 mt-1">All contact form messages will be sent here.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">CC Email <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="email" name="contact_cc_email"
                               value="{{ old('contact_cc_email', $settings['contact_cc_email'] ?? '') }}"
                               class="input-field" placeholder="manager@yourdomain.com" />
                        <p class="text-xs text-gray-400 mt-1">A copy of every message will also go here.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject Prefix</label>
                        <input type="text" name="contact_subject_prefix"
                               value="{{ old('contact_subject_prefix', $settings['contact_subject_prefix'] ?? '[NextGen Store]') }}"
                               class="input-field" placeholder="[Your Store Name]" />
                        <p class="text-xs text-gray-400 mt-1">Prepended to the email subject. E.g. <em>[TTSL Store] Enquiry about your services</em></p>
                    </div>
                </div>
            </div>

            {{-- Auto-reply --}}
            <div class="card p-6" x-data="{ autoReply: {{ ($settings['contact_auto_reply'] ?? '0') === '1' ? 'true' : 'false' }} }">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                            Auto-Reply to Sender
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">Automatically send a reply email to the person who submitted the form.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 ml-4">
                        <input type="hidden" name="contact_auto_reply" value="0" />
                        <input type="checkbox" name="contact_auto_reply" value="1"
                               x-model="autoReply" class="sr-only" />
                        <div class="w-11 h-6 rounded-full transition-colors"
                             :class="autoReply ? 'bg-brand' : 'bg-gray-300'">
                            <div class="w-5 h-5 bg-white rounded-full shadow mt-0.5 transition-transform"
                                 :class="autoReply ? 'translate-x-5 ml-0.5' : 'translate-x-0.5'"></div>
                        </div>
                    </label>
                </div>

                <div x-show="autoReply" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Auto-Reply Message</label>
                    <textarea name="contact_auto_reply_msg" rows="4" class="input-field resize-none"
                              placeholder="Thank you for contacting us...">{{ old('contact_auto_reply_msg', $settings['contact_auto_reply_msg'] ?? '') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Plain text message sent back to the visitor as a confirmation.</p>
                </div>
            </div>

            <button type="submit" class="btn-primary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Contact Settings
            </button>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TAB 3 — STORE INFO
    ═══════════════════════════════════════════════════════════ --}}
    <div x-show="tab === 'store'" x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

        <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-5">
            @csrf

            <div class="card p-6">
                <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Store Contact Information
                </h3>
                <p class="text-xs text-gray-400 mb-5">These details appear in system emails sent to customers.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Store Name <span class="text-red-500">*</span></label>
                        <input type="text" name="store_name"
                               value="{{ old('store_name', $settings['store_name'] ?? '') }}"
                               class="input-field" required placeholder="Your Store Name" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="store_phone"
                               value="{{ old('store_phone', $settings['store_phone'] ?? '') }}"
                               class="input-field" placeholder="+675 000 0000" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Store Email</label>
                        <input type="email" name="store_email"
                               value="{{ old('store_email', $settings['store_email'] ?? '') }}"
                               class="input-field" placeholder="support@yourdomain.com" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                        <input type="url" name="store_website"
                               value="{{ old('store_website', $settings['store_website'] ?? '') }}"
                               class="input-field" placeholder="https://www.yourdomain.com" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Physical Address</label>
                        <input type="text" name="store_address"
                               value="{{ old('store_address', $settings['store_address'] ?? '') }}"
                               class="input-field" placeholder="Port Moresby, Papua New Guinea" />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Store Information
            </button>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TAB 4 — SOCIAL LOGIN
    ═══════════════════════════════════════════════════════════ --}}
    <div x-show="tab === 'social'" x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

        <form method="POST" action="{{ route('admin.settings.social') }}" class="space-y-5">
            @csrf

            {{-- Google OAuth Card --}}
            <div class="card p-6">
                <div class="flex items-start gap-4 mb-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-white border border-gray-200 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800">Google Sign-In</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Allow customers to sign in or register using their Google account.</p>
                            </div>
                            {{-- Enable / Disable Toggle --}}
                            <label class="relative inline-flex items-center cursor-pointer ml-4 flex-shrink-0">
                                <input type="checkbox" name="google_login_enabled" value="1"
                                       class="sr-only peer"
                                       {{ ($settings['google_login_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer
                                            peer-checked:after:translate-x-full peer-checked:after:border-white
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all peer-checked:bg-brand"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Client ID</label>
                        <input type="text" name="google_client_id"
                               value="{{ old('google_client_id', $settings['google_client_id'] ?? '') }}"
                               class="input-field font-mono text-sm"
                               placeholder="xxxxxxxxxx-xxxx.apps.googleusercontent.com" />
                        <p class="text-xs text-gray-400 mt-1">Found in Google Cloud Console → APIs &amp; Services → Credentials.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Client Secret</label>
                        <input type="password" name="google_client_secret"
                               value=""
                               class="input-field font-mono text-sm"
                               placeholder="{{ !empty($settings['google_client_secret'] ?? '') ? '••••••••••••••••' : 'Enter Client Secret' }}"
                               autocomplete="new-password" />
                        <p class="text-xs text-gray-400 mt-1">Leave blank to keep the existing secret. Only enter a new value to update it.</p>
                    </div>
                </div>
            </div>

            {{-- Redirect URI info --}}
            <div class="card p-6 bg-blue-50 border-blue-200">
                <h4 class="font-semibold text-blue-800 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Authorized Redirect URIs
                </h4>
                <p class="text-sm text-blue-700 mb-3">Add <strong>both</strong> of these URIs in your Google Cloud Console under <em>APIs &amp; Services → Credentials → OAuth 2.0 Client → Authorized redirect URIs</em>:</p>
                @php
                    $localRedirect = config('services.google.redirect') && !str_starts_with(config('services.google.redirect'), '/') ? config('services.google.redirect') : 'http://localhost/auth/google/callback';
                    $prodRedirect  = 'https://store.ttsolutionspng.com/auth/google/callback';
                @endphp
                <div class="space-y-2">
                    <div class="flex items-center gap-2 bg-white border border-blue-200 rounded-lg px-3 py-2">
                        <span class="text-xs bg-gray-100 text-gray-500 rounded px-1.5 py-0.5 font-medium flex-shrink-0">Local</span>
                        <code class="text-xs text-gray-700 flex-1 font-mono">{{ $localRedirect }}</code>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $localRedirect }}'); this.textContent='Copied!'; setTimeout(()=>this.textContent='Copy',1500)"
                                class="text-xs text-blue-600 hover:text-blue-800 font-medium flex-shrink-0">Copy</button>
                    </div>
                    <div class="flex items-center gap-2 bg-white border border-blue-200 rounded-lg px-3 py-2">
                        <span class="text-xs bg-green-100 text-green-700 rounded px-1.5 py-0.5 font-medium flex-shrink-0">Live</span>
                        <code class="text-xs text-gray-700 flex-1 font-mono">{{ $prodRedirect }}</code>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $prodRedirect }}'); this.textContent='Copied!'; setTimeout(()=>this.textContent='Copy',1500)"
                                class="text-xs text-blue-600 hover:text-blue-800 font-medium flex-shrink-0">Copy</button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Social Login Settings
            </button>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TAB 5 — ORDER NOTIFICATIONS
    ═══════════════════════════════════════════════════════════ --}}
    <div x-show="tab === 'orders'" x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

        <form method="POST" action="{{ route('admin.settings.order-notifications') }}" class="space-y-5">
            @csrf

            {{-- Customer Confirmation Email --}}
            <div class="card p-6">
                <div class="flex items-start gap-4 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800">Customer Order Confirmation</h3>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    Automatically email the customer when their order is placed successfully.
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer ml-4 flex-shrink-0">
                                <input type="checkbox" name="order_confirmation_enabled" value="1"
                                       class="sr-only peer"
                                       {{ ($settings['order_confirmation_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer
                                            peer-checked:after:translate-x-full peer-checked:after:border-white
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            From Email Address
                            <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="email" name="order_confirmation_from_email"
                               value="{{ old('order_confirmation_from_email', $settings['order_confirmation_from_email'] ?? 'ttsl.support@gmail.com') }}"
                               class="input-field"
                               placeholder="yourname@example.com"
                               required />
                        <p class="text-xs text-gray-400 mt-1">The email address the confirmation is sent <strong>from</strong>. Must match your SMTP account.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            From Name
                            <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="text" name="order_confirmation_from_name"
                               value="{{ old('order_confirmation_from_name', $settings['order_confirmation_from_name'] ?? 'TTSolutions Limited') }}"
                               class="input-field"
                               placeholder="Your Store Name"
                               required />
                        <p class="text-xs text-gray-400 mt-1">The display name the customer sees in their inbox.</p>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-green-50 rounded-lg border border-green-200">
                    <p class="text-xs text-green-700">
                        <strong>How it works:</strong> When a customer clicks <em>Confirm &amp; Place Order</em>,
                        a confirmation email is automatically sent to the email address they entered in the
                        Customer Information field.
                    </p>
                </div>
            </div>

            {{-- Admin Alert Email --}}
            <div class="card p-6">
                <div class="flex items-start gap-4 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800">Admin New Order Alert</h3>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    Send an internal alert to your team email whenever a new order is received.
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer ml-4 flex-shrink-0">
                                <input type="checkbox" name="order_alert_enabled" value="1"
                                       class="sr-only peer"
                                       {{ ($settings['order_alert_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer
                                            peer-checked:after:translate-x-full peer-checked:after:border-white
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alert Recipient Email</label>
                    <input type="email" name="order_alert_email"
                           value="{{ old('order_alert_email', $settings['order_alert_email'] ?? 'ttsl.support@gmail.com') }}"
                           class="input-field"
                           placeholder="yourname@example.com" />
                    <p class="text-xs text-gray-400 mt-1">
                        The email address that receives new order alerts. Leave blank to disable alerts even if the toggle is on.
                    </p>
                </div>
            </div>

            <button type="submit" class="btn-primary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Notification Settings
            </button>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TAB 6 — SAVE MAN AI
    ═══════════════════════════════════════════════════════════ --}}
    <div x-show="tab === 'saveman'" x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

        <form method="POST" action="{{ route('admin.settings.saveman') }}" class="space-y-5">
            @csrf

            {{-- Hero banner --}}
            <div class="card p-6 rounded-xl" style="background:linear-gradient(135deg,#0a2540 0%,#0d3b6e 100%);">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="6" width="18" height="13" rx="2" stroke="white" stroke-width="1.5" fill="none"/>
                            <circle cx="8.5" cy="10.5" r="1" fill="white"/>
                            <circle cx="15.5" cy="10.5" r="1" fill="white"/>
                            <path d="M8 14.5s1.5 2 4 2 4-2 4-2" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M9 6V4.5a3 3 0 016 0V6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-white text-lg leading-tight">Save Man AI Assistant</h3>
                            <span class="text-xs bg-green-400 text-green-900 font-bold px-2 py-0.5 rounded-full">No API Key Required</span>
                        </div>
                        <p class="text-blue-200 text-sm mt-0.5">Built-in store intelligence — works out of the box</p>
                    </div>
                </div>
                <p class="text-blue-100 text-sm leading-relaxed">
                    Save Man is a self-contained AI assistant built directly into your store. It reads your live product catalog, pricing, categories, and store information automatically — no API keys, no subscriptions, no external services needed. Customers can ask about products, ordering, payment, timelines, and more.
                </p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="text-xs bg-white/10 text-blue-100 px-3 py-1 rounded-full">✓ Live product catalog</span>
                    <span class="text-xs bg-white/10 text-blue-100 px-3 py-1 rounded-full">✓ Real-time pricing</span>
                    <span class="text-xs bg-white/10 text-blue-100 px-3 py-1 rounded-full">✓ Order guidance</span>
                    <span class="text-xs bg-white/10 text-blue-100 px-3 py-1 rounded-full">✓ Payment info</span>
                    <span class="text-xs bg-white/10 text-blue-100 px-3 py-1 rounded-full">✓ Zero cost</span>
                </div>
            </div>

            {{-- Enable / Disable --}}
            <div class="card p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800">Enable Save Man</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Show the Save Man chat widget to all store visitors.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer ml-4 flex-shrink-0">
                                <input type="checkbox" name="saveman_enabled" value="1"
                                       class="sr-only peer"
                                       {{ ($settings['saveman_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer
                                            peer-checked:after:translate-x-full peer-checked:after:border-white
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- What Save Man knows --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    What Save Man can answer
                </h3>
                <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                    @foreach([
                        'Product names, prices & availability',
                        'Service categories & descriptions',
                        'How to place an order (step by step)',
                        'Payment methods & bank details',
                        'Project timelines & durations',
                        'Company contact information',
                        'Account registration & login',
                        'Shopping cart & checkout help',
                        'Order status & tracking',
                        'About TTSolutions Limited',
                    ] as $item)
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 mt-4">
                    Save Man automatically updates its knowledge when you add or edit products, categories, or store settings — no action needed.
                </p>
            </div>

            {{-- Test --}}
            <div class="card p-5 bg-blue-50 border border-blue-100" x-data="{ testing: false, result: '' }">
                <h4 class="font-semibold text-blue-800 mb-1 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Test Save Man
                </h4>
                <p class="text-blue-600 text-xs mb-3">Send a live test to see Save Man respond right now.</p>
                <button type="button" @click="testSaveMan($data)"
                        :disabled="testing"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50">
                    <span x-show="!testing">Send Test Message</span>
                    <span x-show="testing">Testing…</span>
                </button>
                <div x-show="result" x-text="result"
                     class="mt-3 text-sm text-blue-800 bg-white border border-blue-200 rounded-lg p-3 leading-relaxed whitespace-pre-line"></div>
            </div>

            <button type="submit" class="btn-primary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Settings
            </button>
        </form>
    </div>

</div>

<script>
async function testSaveMan(data) {
    data.testing = true;
    data.result  = '';
    try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
        const res  = await fetch('/saveman/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ message: 'Hello! What services do you offer and how much do they cost?', history: [] })
        });
        const json = await res.json();
        data.result = json.reply || 'No reply received.';
    } catch (e) {
        data.result = 'Error: ' + e.message;
    }
    data.testing = false;
}
</script>

@endsection
