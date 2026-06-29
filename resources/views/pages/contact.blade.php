@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold">Contact Us</h1>
        <p class="text-blue-100 mt-2">We're here to help</p>
    </div>
</div>
<div class="container mx-auto px-4 py-16 max-w-5xl">
    @if(session('success'))
        <div class="alert-success mb-8 flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="card p-6 text-center">
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Phone</h3>
            <a href="tel:+67572243900" class="text-brand hover:underline">+675 7224 3900</a>
        </div>
        <div class="card p-6 text-center">
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Email</h3>
            <a href="mailto:ttsl.support@gmail.com" class="text-brand hover:underline">ttsl.support@gmail.com</a>
        </div>
        <div class="card p-6 text-center">
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Business Hours</h3>
            <p class="text-gray-600">Mon – Fri: 8:00 AM – 5:00 PM<br>Saturday: 9:00 AM – 1:00 PM<br><span class="text-xs text-gray-400">(Papua New Guinea Time)</span></p>
        </div>
    </div>
    <div class="card p-8 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
        <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input-field @error('name') border-red-500 @enderror" required />
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-field @error('email') border-red-500 @enderror" required />
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                <input type="text" name="subject" value="{{ old('subject') }}" class="input-field" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                <textarea name="message" rows="5" class="input-field @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
                @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-primary w-full py-3">Send Message</button>
        </form>
    </div>
</div>
@endsection
