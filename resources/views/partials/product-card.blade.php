<div class="product-card group flex flex-col">
    {{-- Image area --}}
    <a href="{{ route('shop.product', $product->slug) }}" class="block relative overflow-hidden bg-gray-50 flex-shrink-0">
        <img src="{{ $product->primary_image_url }}"
             alt="{{ $product->name }}"
             class="w-full h-44 sm:h-48 object-contain p-3 group-hover:scale-105 transition-transform duration-300"
             loading="lazy"
             onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'" />
        <div class="absolute top-2 left-2 flex flex-col gap-1 items-start">
            @if($product->is_on_sale)
                <span class="badge bg-accent text-white font-bold text-xs">
                    -{{ $product->discount_percentage }}%
                </span>
            @endif
            @if($product->isCppEligible())
                <span class="badge bg-purple-600 text-white text-xs font-bold">
                    {{ $product->cpp_badge_text ?: 'PROMOTION' }}
                </span>
                @if($product->cppPromotion->max_clients && $product->cppPromotion->remainingSlots() <= 5)
                    <span class="badge bg-red-500 text-white text-xs">Limited Offer</span>
                @endif
            @endif
        </div>
        @if(!$product->is_in_stock)
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <span class="bg-white text-gray-700 font-semibold px-3 py-1 rounded-full text-xs">Out of Stock</span>
            </div>
        @endif
        @if($product->featured && !$product->has_preview)
            <span class="absolute top-2 right-2 badge bg-brand text-white text-xs">Featured</span>
        @endif
        @if($product->has_preview)
            <span class="absolute top-2 right-2 badge bg-indigo-600 text-white text-xs flex items-center gap-1">
                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/><path d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zm0 18a8 8 0 110-16 8 8 0 010 16z"/></svg>
                Live Preview
            </span>
        @endif
    </a>

    {{-- Info area --}}
    <div class="p-3 sm:p-4 flex flex-col flex-1">
        <a href="{{ route('shop.category', $product->category->slug ?? '#') }}"
           class="text-xs text-brand font-medium hover:underline leading-none">
            {{ $product->category->name ?? '' }}
        </a>

        <a href="{{ route('shop.product', $product->slug) }}">
            <h3 class="text-sm font-medium text-gray-800 mt-1 mb-2 line-clamp-2 hover:text-brand transition-colors leading-snug">
                {{ $product->name }}
            </h3>
        </a>

        @if($product->is_in_stock && $product->stock <= 5)
            <p class="text-xs text-orange-500 mb-1.5 flex items-center gap-1">
                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Only {{ $product->stock }} left!
            </p>
        @endif

        @if($product->has_preview)
            <a href="{{ route('shop.product', $product->slug) }}#live-preview-section"
               class="flex items-center gap-1 text-xs text-indigo-600 hover:text-indigo-800 font-medium mb-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                View Live Preview
            </a>
        @endif

        {{-- Price + cart button --}}
        <div class="flex items-end justify-between mt-auto pt-2 border-t border-gray-100">
            <div>
                <div class="text-base sm:text-lg font-bold text-brand leading-none">
                    K {{ number_format($product->current_price, 2) }}
                </div>
                @if($product->is_on_sale)
                    <div class="text-xs text-gray-400 line-through leading-tight mt-0.5">
                        K {{ number_format($product->price, 2) }}
                    </div>
                @endif
            </div>
            @if($product->is_in_stock)
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                    <input type="hidden" name="quantity" value="1" />
                    <button type="submit"
                            @guest onclick="window.location='{{ route('login') }}'; return false;" @endguest
                            class="w-9 h-9 bg-brand text-white rounded-lg flex items-center justify-center hover:bg-brand-light transition-colors flex-shrink-0"
                            title="Add to cart">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
