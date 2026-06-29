@extends('layouts.app')
@section('title', 'My Addresses')

@section('content')
<div class="page-header"><div class="container mx-auto px-4"><h1 class="text-3xl font-bold">Saved Addresses</h1></div></div>
<div class="container mx-auto px-4 py-8 max-w-3xl">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        @foreach($addresses as $address)
            <div class="card p-5 relative {{ $address->is_default ? 'border-brand border-2' : '' }}">
                @if($address->is_default)
                    <span class="absolute top-3 right-3 badge bg-brand text-white text-xs">Default</span>
                @endif
                <p class="font-semibold">{{ $address->full_name }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $address->full_address }}</p>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> {{ $address->phone }}</p>
                <form method="POST" action="{{ route('account.address.delete', $address) }}" class="mt-3">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:text-red-700" onclick="return confirm('Delete this address?')">Delete</button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="card p-6">
        <h2 class="font-bold text-lg mb-4">Add New Address</h2>
        <form method="POST" action="{{ route('account.address.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label><input type="text" name="full_name" class="input-field" required /></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label><input type="text" name="phone" class="input-field" required /></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Province *</label>
                    <select name="province" class="input-field" required>
                        <option value="">Select Province</option>
                        @foreach(['National Capital District','Central','Milne Bay','Oro','Southern Highlands','Enga','Western Highlands','Simbu','Eastern Highlands','Morobe','Madang','East Sepik','West Sepik','Manus','New Ireland','East New Britain','West New Britain','Bougainville','Western','Gulf'] as $prov)
                            <option value="{{ $prov }}">{{ $prov }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">City *</label><input type="text" name="city" class="input-field" required /></div>
                <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Address *</label><textarea name="address" rows="2" class="input-field" required></textarea></div>
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_default" value="1" class="rounded text-brand" />
                        <span class="text-sm text-gray-700">Set as default address</span>
                    </label>
                </div>
            </div>
            <button type="submit" class="btn-primary mt-4">Save Address</button>
        </form>
    </div>
</div>
@endsection
