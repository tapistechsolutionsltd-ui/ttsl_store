@extends('layouts.app')
@section('title', 'My Wishlist')

@section('content')
<div class="page-header"><div class="container mx-auto px-4"><h1 class="text-3xl font-bold">My Wishlist</h1></div></div>
<div class="container mx-auto px-4 py-8">
    @if($wishlists->isEmpty())
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Your wishlist is empty</h2>
            <a href="{{ route('shop') }}" class="btn-primary">Explore Products</a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($wishlists as $item)
                @include('partials.product-card', ['product' => $item->product])
            @endforeach
        </div>
        <div class="mt-6">{{ $wishlists->links() }}</div>
    @endif
</div>
@endsection
