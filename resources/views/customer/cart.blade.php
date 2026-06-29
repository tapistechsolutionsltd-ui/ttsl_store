@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold">Shopping Cart</h1>
        <p class="text-blue-100 mt-1">{{ $cart->item_count }} item(s) in your cart</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    @if($cart->items->isEmpty())
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-700 mb-3">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Browse our products and add items to your cart</p>
            <a href="{{ route('shop') }}" class="btn-primary text-lg px-8 py-4">Start Shopping</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="card p-4 flex gap-4">
                        <a href="{{ route('shop.product', $item->product->slug) }}" class="flex-shrink-0">
                            <img src="{{ $item->product->primary_image_url }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-24 h-24 object-cover rounded-lg"
                                 onerror="this.src='https://via.placeholder.com/100?text=No+Image'" />
                        </a>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('shop.product', $item->product->slug) }}"
                               class="font-semibold text-gray-800 hover:text-brand line-clamp-2 leading-snug">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-sm text-gray-400 mt-0.5">SKU: {{ $item->product->sku }}</p>
                            @if(!empty($item->features))
                                <ul class="text-xs text-gray-500 mt-1.5 space-y-0.5">
                                    @foreach($item->features as $f)
                                        <li>+ {{ $f['name'] }} <span class="text-gray-400">(K {{ number_format($f['price'], 2) }})</span></li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                        @csrf @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                                            class="px-3 py-1.5 hover:bg-gray-50 text-gray-600">−</button>
                                        <span class="px-4 py-1.5 border-x border-gray-200 font-semibold text-sm min-w-10 text-center">{{ $item->quantity }}</span>
                                        <button type="submit" name="quantity" value="{{ min($item->product->stock, $item->quantity + 1) }}"
                                            class="px-3 py-1.5 hover:bg-gray-50 text-gray-600">+</button>
                                    </form>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-brand">K {{ number_format($item->total, 2) }}</div>
                                    <div class="text-xs text-gray-400">K {{ number_format($item->price, 2) }} each</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <form method="POST" action="{{ route('cart.save', $item) }}">
                                @csrf
                                <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 whitespace-nowrap">Save</button>
                            </form>
                            <form method="POST" action="{{ route('cart.remove', $item) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-400 hover:text-red-600 whitespace-nowrap">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach

                {{-- Saved for Later --}}
                @if($cart->savedItems->isNotEmpty())
                    <div class="mt-8">
                        <h3 class="font-semibold text-gray-700 mb-3">Saved for Later ({{ $cart->savedItems->count() }})</h3>
                        @foreach($cart->savedItems as $item)
                            <div class="card p-4 flex gap-4 opacity-75">
                                <img src="{{ $item->product->primary_image_url }}" alt=""
                                     class="w-16 h-16 object-cover rounded-lg flex-shrink-0" />
                                <div class="flex-1">
                                    <p class="font-medium text-gray-700">{{ $item->product->name }}</p>
                                    <p class="text-brand font-semibold">K {{ number_format($item->price, 2) }}</p>
                                    <form method="POST" action="{{ route('cart.move', $item) }}" class="mt-2">
                                        @csrf
                                        <button type="submit" class="text-sm text-brand hover:underline">Move to Cart</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-between pt-4">
                    <a href="{{ route('shop') }}" class="text-brand hover:underline text-sm">← Continue Shopping</a>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="space-y-4">
                {{-- Coupon --}}
                <div class="card p-5">
                    <h3 class="font-semibold text-gray-800 mb-3">Coupon Code</h3>
                    @if(session('applied_coupon'))
                        <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                            <span class="text-green-700 font-semibold">{{ session('applied_coupon') }}</span>
                            <form method="POST" action="{{ route('cart.coupon.remove') }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500">Remove</button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('cart.coupon') }}" class="flex gap-2">
                            @csrf
                            <input type="text" name="coupon" placeholder="Enter code" class="input-field py-2 text-sm flex-1" />
                            <button type="submit" class="btn-primary btn-sm whitespace-nowrap">Apply</button>
                        </form>
                    @endif
                </div>

                {{-- Summary --}}
                <div class="card p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">Order Summary</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal ({{ $cart->item_count }} items)</span>
                            <span class="font-medium">K {{ number_format($cart->subtotal, 2) }}</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between">
                            <span class="font-bold text-gray-800 text-base">Total</span>
                            <span class="font-bold text-brand text-xl">K {{ number_format($cart->subtotal, 2) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn-primary w-full text-center mt-4 block py-4 text-lg">
                        Proceed to Checkout →
                    </a>
                    <p class="text-center text-xs text-gray-400 mt-3 flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Secure checkout
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
