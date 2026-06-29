@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Forgot Password?</h1>
            <p class="text-gray-500 mt-2">Enter your email to receive a reset link</p>
        </div>
        @if(session('status'))
            <div class="alert-success mb-4">{{ session('status') }}</div>
        @endif
        <div class="card p-8">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="input-field @error('email') border-red-500 @enderror" required />
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn-primary w-full py-3">Send Reset Link</button>
            </form>
            <p class="text-center text-sm text-gray-500 mt-4">
                <a href="{{ route('login') }}" class="text-brand hover:underline">← Back to Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
