@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- ════════════════════════════════════════════════════════════
     HERO CAROUSEL  (full-width)
════════════════════════════════════════════════════════════ --}}
@if($heroSlides->isNotEmpty())
@php $refSlide = $heroSlides->first(fn($s) => $s->image_path && !$s->is_video); @endphp
<section x-data="heroSlider({{ $heroSlides->count() }})" x-init="init()"
         @mouseenter="stopTimer()" @mouseleave="if(total > 1) startTimer()"
         class="relative overflow-hidden w-full">

    @foreach($heroSlides as $i => $slide)
        <div x-show="current === {{ $i }}"
             x-transition:enter="transition-opacity ease-in-out duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in-out duration-700"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 overflow-hidden"
             style="background-color: {{ $slide->bg_color ?? '#0a2540' }};">

            {{-- Full image/video fills the slide --}}
            @if($slide->image_path)
                @if($slide->is_video)
                    <video src="{{ $slide->image_url }}"
                           autoplay loop muted playsinline
                           aria-hidden="true"
                           class="absolute inset-0 w-full h-full"
                           style="object-fit: cover; object-position: center;"></video>
                @else
                    <img src="{{ $slide->image_url }}" alt=""
                         aria-hidden="true"
                         class="absolute inset-0 w-full h-full"
                         style="object-fit: cover; object-position: center;">
                @endif
            @endif

            {{-- Overlay --}}
            @if($slide->image_path && $slide->overlay_opacity > 0)
                <div class="absolute inset-0" style="background: rgba(0,0,0,{{ $slide->overlay_opacity / 100 }});"></div>
            @endif

            {{-- Text content --}}
            <div class="absolute inset-0 flex items-center"
                 style="color: {{ $slide->text_color }}">
                <div class="w-full max-w-screen-2xl mx-auto px-4 sm:px-10 py-8 sm:py-16 md:py-24">
                    <div class="max-w-2xl">
                        @if($slide->badge_text)
                            <span class="inline-block text-white text-xs font-bold px-3 py-1 rounded-full mb-4 uppercase tracking-wider"
                                  style="background-color: {{ $slide->badge_color }}">
                                {{ $slide->badge_text }}
                            </span>
                        @endif
                        @if($slide->title)
                            <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold mb-4 leading-tight">
                                {!! nl2br(e($slide->title)) !!}
                            </h1>
                        @endif
                        @if($slide->subtitle)
                            <p class="text-xl sm:text-2xl font-semibold mb-3 opacity-90">{{ $slide->subtitle }}</p>
                        @endif
                        @if($slide->description)
                            <p class="text-base sm:text-lg mb-8 max-w-lg opacity-80">{{ $slide->description }}</p>
                        @endif
                        @if($slide->button_text || $slide->secondary_button_text)
                            <div class="flex flex-wrap gap-3">
                                @if($slide->button_text)
                                    <a href="{{ $slide->button_url ?: '/shop' }}"
                                       class="inline-flex items-center gap-2 bg-accent hover:bg-accent-dark text-white font-bold px-7 py-3.5 rounded-lg transition-colors text-base">
                                        {{ $slide->button_text }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @endif
                                @if($slide->secondary_button_text)
                                    <a href="{{ $slide->secondary_button_url ?: '/contact' }}"
                                       class="inline-flex items-center gap-2 border-2 font-bold px-7 py-3.5 rounded-lg hover:bg-white/10 transition-colors text-base"
                                       style="border-color: {{ $slide->text_color }}; color: {{ $slide->text_color }}">
                                        {{ $slide->secondary_button_text }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Natural-height spacer: invisible <img> sizes the section to the image's actual proportions on every screen --}}
    @if($refSlide)
        <img src="{{ $refSlide->image_url }}"
             alt="" aria-hidden="true"
             class="w-full h-auto block"
             style="visibility: hidden; pointer-events: none; user-select: none;">
    @else
        {{-- No static image to size from (e.g. video-only slides) — fall back to a 16:9 box --}}
        <div class="w-full" style="visibility: hidden; aspect-ratio: 16/9; min-height: 300px;"></div>
    @endif

    @if($heroSlides->count() > 1)
        <button @click="prev()" aria-label="Previous"
            class="absolute left-3 sm:left-5 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white rounded-full p-2 sm:p-3 transition-colors z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" aria-label="Next"
            class="absolute right-3 sm:right-5 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white rounded-full p-2 sm:p-3 transition-colors z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            @foreach($heroSlides as $i => $slide)
                <button @click="goTo({{ $i }})"
                    :class="current === {{ $i }} ? 'bg-white w-6' : 'bg-white/40 w-2'"
                    class="h-2 rounded-full transition-all duration-300">
                </button>
            @endforeach
        </div>
    @endif
</section>

@else
{{-- Static fallback hero --}}
<section class="bg-gradient-to-br from-brand-dark via-brand to-brand text-white min-h-[260px] sm:min-h-[380px] md:min-h-[420px]">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-10 py-12 sm:py-20 md:py-28 flex items-center min-h-[260px] sm:min-h-[380px] md:min-h-[420px]">
        <div class="max-w-2xl">
            <span class="inline-block bg-accent text-white text-xs font-bold px-3 py-1 rounded-full mb-5 uppercase tracking-wider">
                Papua New Guinea's #1 ICT Store
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Technology &amp;<br>Industrial Solutions<br>
                <span class="text-accent-light">For PNG</span>
            </h1>
            <p class="text-lg text-white/80 mb-8 max-w-lg">
                Computers, laptops, office supplies, heavy equipment and more — all priced in Papua New Guinea Kina.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('shop') }}"
                   class="inline-flex items-center gap-2 bg-accent hover:bg-accent-dark text-white font-bold px-7 py-3.5 rounded-lg transition-colors">
                    Shop Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 border-2 border-white text-white font-bold px-7 py-3.5 rounded-lg hover:bg-white/10 transition-colors">
                    Contact Us
                </a>
            </div>
            <div class="flex gap-8 mt-10 text-sm text-white/60">
                <div><span class="text-2xl font-bold text-white">500+</span><br>Products</div>
                <div><span class="text-2xl font-bold text-white">9</span><br>Categories</div>
                <div><span class="text-2xl font-bold text-white">PNG</span><br>Currency</div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     SHOP BY DEPARTMENT
════════════════════════════════════════════════════════════ --}}
@if($categories->isNotEmpty())
<section class="py-8 bg-gray-100 hidden md:block">
    <div class="max-w-screen-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Shop by Department</h2>
            <a href="{{ route('shop') }}" class="text-sm text-brand font-semibold hover:underline flex items-center gap-1">
                See all
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
            @foreach($categories as $category)
                <a href="{{ route('shop.category', $category->slug) }}"
                   class="bg-white rounded-xl p-4 sm:p-5 text-center hover:shadow-md hover:border-brand transition-all group border border-gray-200">
                    <div class="text-sm font-semibold text-gray-800 group-hover:text-brand line-clamp-2 leading-tight">
                        {{ $category->name }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1.5">
                        {{ $category->active_products_count ?? 0 }} items
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     FEATURED PRODUCTS
════════════════════════════════════════════════════════════ --}}
@if($featuredProducts->isNotEmpty())
<section class="py-8 bg-white">
    <div class="max-w-screen-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Featured Products</h2>
                <p class="text-gray-500 text-sm mt-0.5">Hand-picked for you</p>
            </div>
            <a href="{{ route('shop') }}?featured=1"
               class="text-brand text-sm font-semibold hover:underline flex items-center gap-1">
                See all featured
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     SERVICES BANNER STRIP
════════════════════════════════════════════════════════════ --}}
<section class="py-8 bg-brand">
    <div class="max-w-screen-2xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center text-white">
            <div class="flex items-center justify-center gap-3 py-2">
                <div class="w-11 h-11 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="font-bold text-sm">We Build</div>
                    <div class="text-xs text-white/70">Custom websites &amp; web apps</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3 py-2">
                <div class="w-11 h-11 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="font-bold text-sm">We Host</div>
                    <div class="text-xs text-white/70">Fast &amp; reliable cloud hosting</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3 py-2">
                <div class="w-11 h-11 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="font-bold text-sm">We Support</div>
                    <div class="text-xs text-white/70">Ongoing maintenance &amp; help</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════
     NEW ARRIVALS
════════════════════════════════════════════════════════════ --}}
@if($newArrivals->isNotEmpty())
<section class="py-8 bg-gray-100">
    <div class="max-w-screen-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">New Arrivals</h2>
                <p class="text-gray-500 text-sm mt-0.5">Fresh stock just in</p>
            </div>
            <a href="{{ route('shop') }}?sort=latest"
               class="text-brand text-sm font-semibold hover:underline flex items-center gap-1">
                See all
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
            @foreach($newArrivals as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     BRANDS
════════════════════════════════════════════════════════════ --}}
@if($brands->isNotEmpty())
<section class="py-8 bg-white border-t border-gray-100 overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-4 mb-5">
        <h3 class="text-center text-gray-400 text-xs font-bold uppercase tracking-widest">Our Trusted Development Tools</h3>
    </div>
    {{-- Infinite scrolling marquee — pauses on hover --}}
    <div class="devtools-marquee-wrapper">
        <div class="devtools-marquee-track">
            @php $loopBrands = $brands->concat($brands); @endphp
            @foreach($loopBrands as $brand)
                @if($brand->website_url)
                    <a href="{{ $brand->website_url }}" target="_blank" rel="noopener"
                       class="devtools-item group">
                @else
                    <div class="devtools-item group">
                @endif
                        @if($brand->logo)
                            <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}"
                                 class="h-8 object-contain transition-transform duration-300 group-hover:scale-110">
                        @else
                            <span class="text-gray-700 font-semibold text-sm group-hover:text-brand transition-colors">{{ $brand->name }}</span>
                        @endif
                @if($brand->website_url)
                    </a>
                @else
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     CTA BANNER
════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-brand-dark text-white text-center">
    <div class="max-w-screen-2xl mx-auto px-4">
        <h2 class="text-3xl sm:text-4xl font-bold mb-3">Ready to Order?</h2>
        <p class="text-white/70 text-base sm:text-lg mb-8 max-w-xl mx-auto">
            Get the best ICT and industrial equipment delivered to your door in Papua New Guinea.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('shop') }}"
               class="inline-flex items-center gap-2 bg-accent hover:bg-accent-dark text-white font-bold px-8 py-4 rounded-lg transition-colors text-base">
                Browse Products
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 border-2 border-white text-white font-bold px-8 py-4 rounded-lg hover:bg-white/10 transition-colors text-base">
                Get a Quote
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function heroSlider(count) {
    return {
        current: 0,
        total: count,
        timer: null,
        init() {
            if (this.total > 1) this.startTimer();
        },
        startTimer() {
            if (this.timer) clearInterval(this.timer);
            this.timer = setInterval(() => {
                this.current = (this.current + 1) % this.total;
            }, 6000);
        },
        stopTimer() {
            if (this.timer) { clearInterval(this.timer); this.timer = null; }
        },
        next() { this.current = (this.current + 1) % this.total; this.startTimer(); },
        prev() { this.current = (this.current - 1 + this.total) % this.total; this.startTimer(); },
        goTo(i) { this.current = i; this.startTimer(); }
    }
}
</script>
@endpush
