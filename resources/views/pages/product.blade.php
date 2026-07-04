@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-brand">Home</a>
        <span>/</span>
        <a href="{{ route('shop') }}" class="hover:text-brand">Shop</a>
        <span>/</span>
        @if($product->category)
            <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-brand">{{ $product->category->name }}</a>
            <span>/</span>
        @endif
        <span class="text-gray-800 font-medium truncate">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">

        {{-- Images --}}
        <div x-data="{ active: '{{ $product->primary_image_url }}' }">
            <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 mb-4 border border-gray-100">
                <img :src="active" alt="{{ $product->name }}"
                     class="w-full h-full object-cover" />
            </div>
            @if($product->images->count() > 1)
                <div class="grid grid-cols-5 gap-2">
                    @foreach($product->images as $img)
                        <button @click="active='{{ $img->url }}'"
                            class="aspect-square rounded-lg overflow-hidden border-2 transition-colors"
                            :class="active === '{{ $img->url }}' ? 'border-brand' : 'border-gray-200 hover:border-gray-400'">
                            <img src="{{ $img->url }}" alt="" class="w-full h-full object-cover" />
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        @php
            $initialSelectedFeatures = $features->whereIn('id', $selectedFeatureIds)
                ->mapWithKeys(fn($f) => [$f->id => (float) $f->price])->all();
        @endphp
        <div x-data="featureSelector({{ $product->current_price }}, {{ json_encode($initialSelectedFeatures, JSON_FORCE_OBJECT) }})">
            @if($product->brand)
                <a href="{{ route('shop') }}?brand={{ $product->brand->slug }}"
                   class="text-sm font-semibold text-brand hover:underline">{{ $product->brand->name }}</a>
            @endif
            <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-4">{{ $product->name }}</h1>

            {{-- Price --}}
            <div class="flex items-center gap-4 mb-1">
                <span class="text-4xl font-bold text-brand">K {{ number_format($product->current_price, 2) }}</span>
                @if($product->is_on_sale)
                    <span class="text-xl text-gray-400 line-through">K {{ number_format($product->price, 2) }}</span>
                    <span class="badge bg-red-100 text-red-700 font-bold text-sm">Save {{ $product->discount_percentage }}%</span>
                @endif
            </div>
            <p class="text-xs text-gray-400 mb-4">Standard price for website development only. Add optional features below to customize your build.</p>

            {{-- Optional Add-on Features --}}
            @if($features->isNotEmpty())
                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="text-sm font-bold text-gray-800 mb-3">Customize Your Website — Optional Add-ons</p>
                    <div class="space-y-2">
                        @foreach($features as $feature)
                            <label class="flex items-start gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-brand cursor-pointer transition-colors">
                                <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                                       @change="toggleFeature({{ $feature->id }}, {{ $feature->price }})"
                                       form="add-to-cart-form"
                                       {{ in_array($feature->id, $selectedFeatureIds) ? 'checked' : '' }}
                                       class="mt-1 w-4 h-4 text-brand rounded focus:ring-brand">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-medium text-gray-800 text-sm">{{ $feature->name }}</span>
                                        <span class="font-semibold text-brand text-sm whitespace-nowrap">+ K {{ number_format($feature->price, 2) }}</span>
                                    </div>
                                    @if($feature->description)
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $feature->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Live total --}}
                <div class="flex items-center justify-between p-4 bg-brand/5 rounded-xl border border-brand/20 mb-6">
                    <span class="font-bold text-gray-800">Total Price</span>
                    <span class="text-2xl font-bold text-brand" x-text="'K ' + total.toFixed(2)"></span>
                </div>
            @endif

            {{-- License # & Availability --}}
            <div class="flex flex-wrap gap-6 text-sm mb-6">
                <div><span class="text-gray-500">License #:</span> <span class="font-mono font-medium">{{ $product->sku }}</span></div>
                <div>
                    <span class="text-gray-500">Availability:</span>
                    @if($product->is_in_stock)
                        <span class="font-medium text-green-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> {{ $product->availability_label }}</span>
                    @else
                        <span class="font-medium text-red-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg> Unavailable</span>
                    @endif
                </div>
            </div>

            @if($product->isCppEligible())
                <div class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-xl">
                    <p class="text-sm text-purple-800 flex items-start gap-2">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>This product qualifies for the <a href="{{ route('cpp.show', $product->cppPromotion) }}" class="font-bold underline">Client Promotions Portal</a>. Upon successful order you will receive a Promotion Code.</span>
                    </p>
                </div>
            @endif

            @if($product->description)
                <div class="text-gray-600 leading-relaxed mb-6 pb-6 border-b border-gray-100">
                    {!! nl2br(e($product->description)) !!}
                </div>
            @endif

            {{-- Add to Cart --}}
            {{-- Development Timeline Card --}}
            <div class="mb-6 p-4 bg-gradient-to-r from-brand/5 to-indigo-50 rounded-xl border border-brand/20">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-brand/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold uppercase tracking-widest text-brand mb-0.5">Development Timeline</p>
                        <p class="font-bold text-gray-900">{{ $product->development_duration ?? '3 Weeks' }}</p>
                        <p class="text-xs text-gray-500 mt-1">Estimated from order confirmation &amp; payment. You&rsquo;ll receive progress updates throughout development.</p>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-brand/15 grid grid-cols-3 gap-2 text-center text-xs text-gray-500">
                    <div><span class="block font-semibold text-gray-700">1</span>Order &amp; Pay</div>
                    <div><span class="block font-semibold text-gray-700">2</span>Development</div>
                    <div><span class="block font-semibold text-gray-700">3</span>Handover</div>
                </div>
            </div>

            @if($product->is_in_stock)
                @auth
                    <form id="add-to-cart-form" method="POST" action="{{ route('cart.add') }}" class="flex gap-3 mb-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <button type="button" id="qty-dec" class="px-4 py-3 hover:bg-gray-50 font-semibold text-lg">−</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}"
                                class="w-16 text-center border-x border-gray-300 py-3 focus:outline-none text-lg font-semibold" />
                            <button type="button" id="qty-inc" class="px-4 py-3 hover:bg-gray-50 font-semibold text-lg">+</button>
                        </div>
                        <button type="submit" class="btn-primary flex-1 text-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Add to Cart
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-primary w-full text-center text-lg mb-6 block py-4">
                        Login to Purchase
                    </a>
                @endauth
            @else
                <button disabled class="btn-primary w-full opacity-50 cursor-not-allowed text-lg py-4 mb-6">
                    Currently Unavailable
                </button>
            @endif

            {{-- Wishlist --}}
            @auth
                <button id="wishlist-btn" onclick="toggleWishlist({{ $product->id }})"
                    class="flex items-center gap-2 text-sm {{ $isWishlisted ? 'text-red-500' : 'text-gray-500' }} hover:text-red-500 transition-colors mb-6">
                    <svg class="w-5 h-5" fill="{{ $isWishlisted ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span id="wishlist-text">{{ $isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}</span>
                </button>
            @endauth

            {{-- Service badges --}}
            <div class="grid grid-cols-3 gap-3 p-4 bg-gray-50 rounded-xl text-center text-xs text-gray-600">
                <div class="flex flex-col items-center gap-1">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    <span class="font-medium">We Build<br><span class="font-normal text-gray-400">Custom sites</span></span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                    <span class="font-medium">We Host<br><span class="font-normal text-gray-400">Cloud hosting</span></span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="font-medium">We Support<br><span class="font-normal text-gray-400">Ongoing help</span></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Live Website Preview --}}
    @if($product->has_preview)
        <div class="card overflow-hidden mb-8" id="live-preview-section">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-red-400"></span>
                        <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                        <span class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></span>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-900 leading-none">Live Preview</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Interactive — click, scroll and explore the website</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button id="preview-toggle-device"
                        onclick="togglePreviewDevice()"
                        title="Toggle mobile/desktop view"
                        class="p-2 rounded-lg text-gray-500 hover:bg-indigo-100 hover:text-indigo-700 transition-colors">
                        <svg id="icon-desktop" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <svg id="icon-mobile" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </button>
                    <a href="{{ $product->preview_url }}" target="_blank"
                       class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Open Fullscreen
                    </a>
                </div>
            </div>

            {{-- Browser chrome --}}
            <div class="bg-gray-100 border-b border-gray-200 px-4 py-2 flex items-center gap-2">
                <div class="flex-1 bg-white rounded-md px-3 py-1 text-xs text-gray-400 truncate border border-gray-200 select-none">
                    {{ $product->preview_url }}
                </div>
            </div>

            <div id="preview-wrapper" class="relative bg-gray-50 flex justify-center transition-all duration-300" style="min-height:560px;">
                <iframe
                    id="preview-iframe"
                    src="{{ $product->preview_url }}"
                    class="w-full border-0 transition-all duration-300"
                    style="height:560px;"
                    sandbox="allow-scripts allow-forms allow-popups allow-modals"
                    loading="lazy"
                    title="Live Preview: {{ $product->name }}"
                ></iframe>
                {{-- Loading overlay --}}
                <div id="preview-loading"
                     class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50 gap-3 z-10">
                    <svg class="w-8 h-8 text-indigo-400 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <p class="text-sm text-gray-500">Loading preview…</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Specifications --}}
    @if($product->specifications)
        <div class="card p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Specifications</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($product->specifications as $key => $value)
                    <div class="flex gap-3 py-2 border-b border-gray-100">
                        <span class="text-gray-500 font-medium w-40 flex-shrink-0">{{ $key }}</span>
                        <span class="text-gray-800">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())
        <div>
            <h2 class="section-title mb-6">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    @include('partials.product-card', ['product' => $related])
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function featureSelector(basePrice, initialSelected) {
    return {
        basePrice: basePrice,
        selected: { ...(initialSelected || {}) },
        get total() {
            return this.basePrice + Object.values(this.selected).reduce((a, b) => a + b, 0);
        },
        toggleFeature(id, price) {
            if (this.selected[id] !== undefined) {
                delete this.selected[id];
            } else {
                this.selected[id] = price;
            }
        }
    }
}

document.getElementById('qty-dec')?.addEventListener('click', () => {
    const input = document.getElementById('qty');
    if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
});
document.getElementById('qty-inc')?.addEventListener('click', () => {
    const input = document.getElementById('qty');
    const max = parseInt(input.max);
    if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
});

// Hide loading overlay once iframe loads
const iframe = document.getElementById('preview-iframe');
if (iframe) {
    iframe.addEventListener('load', () => {
        const overlay = document.getElementById('preview-loading');
        if (overlay) overlay.style.display = 'none';
    });
}

let isMobile = false;
function togglePreviewDevice() {
    isMobile = !isMobile;
    const iframe  = document.getElementById('preview-iframe');
    const wrapper = document.getElementById('preview-wrapper');
    const iconD   = document.getElementById('icon-desktop');
    const iconM   = document.getElementById('icon-mobile');
    if (isMobile) {
        iframe.style.width  = '390px';
        iframe.style.height = '844px';
        wrapper.style.minHeight = '844px';
        wrapper.style.paddingTop = '16px';
        wrapper.style.paddingBottom = '16px';
        iconD.classList.add('hidden');
        iconM.classList.remove('hidden');
    } else {
        iframe.style.width  = '100%';
        iframe.style.height = '560px';
        wrapper.style.minHeight = '560px';
        wrapper.style.paddingTop = '';
        wrapper.style.paddingBottom = '';
        iconD.classList.remove('hidden');
        iconM.classList.add('hidden');
    }
}

async function toggleWishlist(productId) {
    const res = await fetch('{{ route('account.wishlist.toggle') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify({ product_id: productId })
    });
    const data = await res.json();
    const btn = document.getElementById('wishlist-btn');
    const txt = document.getElementById('wishlist-text');
    const svg = btn.querySelector('svg');
    if (data.status === 'added') {
        btn.classList.add('text-red-500');
        svg.setAttribute('fill', 'currentColor');
        txt.textContent = 'Remove from Wishlist';
    } else {
        btn.classList.remove('text-red-500');
        svg.setAttribute('fill', 'none');
        txt.textContent = 'Add to Wishlist';
    }
    // Update wishlist badge in nav
    const badge = document.querySelector('.wishlist-count');
    if (badge) {
        if (data.count > 0) {
            badge.textContent = data.count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}
</script>
@endpush
