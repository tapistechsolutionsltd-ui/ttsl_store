@extends('layouts.app')
@section('title', 'Verify Email')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md text-center">
        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-3">Verify Your Email</h1>
        <p class="text-gray-500 mb-8">We sent a verification link to <strong>{{ auth()->user()->email }}</strong>. Click it to activate your account.</p>

        @if(session('status') === 'verification-link-sent')
            <div class="alert-success mb-6">A new verification link has been sent to your email.</div>
        @endif

        <div class="card p-6 text-left mb-6">
            <p class="text-sm text-gray-600 mb-4">Didn't receive the email? Check your spam folder, or click below to resend.</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full">Resend Verification Email</button>
            </form>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Sign out and use a different account</button>
        </form>
    </div>
</div>
@endsection
