@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="page-header"><div class="container mx-auto px-4"><h1 class="text-3xl font-bold">My Profile</h1></div></div>
<div class="container mx-auto px-4 py-8 max-w-2xl">

    @if(session('success'))
        <div class="alert-success mb-4 flex items-center gap-2"><svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> {{ session('success') }}</div>
    @endif

    <div class="card p-6 mb-6">
        <h2 class="font-bold text-lg mb-4">Personal Information</h2>
        <form method="POST" action="{{ route('account.profile.update') }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="input-field @error('name') border-red-500 @enderror" required />
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email (read-only)</label>
                    <input type="email" value="{{ $user->email }}" class="input-field bg-gray-50" disabled />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field" />
                </div>
            </div>
            <button type="submit" class="btn-primary mt-4">Save Changes</button>
        </form>
    </div>

    <div class="card p-6">
        <h2 class="font-bold text-lg mb-4">Change Password</h2>
        <form method="POST" action="{{ route('account.password.update') }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password *</label>
                    <input type="password" name="current_password"
                        class="input-field @error('current_password') border-red-500 @enderror" required />
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password *</label>
                    <input type="password" name="password"
                        class="input-field @error('password') border-red-500 @enderror" required />
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" class="input-field" required />
                </div>
            </div>
            <button type="submit" class="btn-primary mt-4">Update Password</button>
        </form>
    </div>
</div>
@endsection
