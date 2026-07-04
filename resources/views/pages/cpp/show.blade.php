@extends('layouts.app')
@section('title', $promotion->title)

@section('content')
@php $status = $promotion->effective_status; @endphp

<div class="bg-brand-dark text-white py-14 relative overflow-hidden">
    @if($promotion->banner_image)
        <img src="{{ asset('storage/' . $promotion->banner_image) }}" class="absolute inset-0 w-full h-full object-cover opacity-20" alt="">
    @endif
    <div class="max-w-screen-xl mx-auto px-4 text-center relative">
        <span class="badge {{ $status === 'published' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} mb-3 inline-block">
            {{ $status === 'published' ? 'OPEN FOR REGISTRATION' : ($status === 'closed' ? 'PROMOTION FULL' : 'PROMOTION CLOSED') }}
        </span>
        <h1 class="text-3xl sm:text-4xl font-bold mb-3">{{ $promotion->title }}</h1>
        @if($promotion->subtitle)
            <p class="text-blue-200 max-w-2xl mx-auto">{{ $promotion->subtitle }}</p>
        @endif
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 -mt-8 mb-12 relative z-10" x-data="cppShow()">

    {{-- Stats + Countdown --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @if($promotion->show_client_counter)
            <div class="stat-card text-center">
                <p class="text-gray-500 text-xs uppercase tracking-wide">Registered</p>
                <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.registered ?? {{ $stats['registered'] }}"></p>
            </div>
        @endif
        @if($promotion->show_remaining_slots)
            <div class="stat-card text-center">
                <p class="text-gray-500 text-xs uppercase tracking-wide">Remaining Slots</p>
                <p class="text-2xl font-bold text-brand mt-1" x-text="stats.remaining ?? '{{ $stats['remaining'] ?? 'Unlimited' }}'"></p>
            </div>
        @endif
        <div class="stat-card text-center">
            <p class="text-gray-500 text-xs uppercase tracking-wide">Max Clients</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $promotion->max_clients ?? 'Unlimited' }}</p>
        </div>
        <div class="stat-card text-center">
            <p class="text-gray-500 text-xs uppercase tracking-wide">Status</p>
            <p class="text-2xl font-bold mt-1 {{ $status === 'published' ? 'text-green-600' : 'text-red-500' }}">
                {{ $status === 'published' ? 'OPEN' : 'CLOSED' }}
            </p>
        </div>
    </div>

    @if($allowCountdown && $promotion->expiry_date)
        <div class="card p-6 mb-8 text-center" x-init="startCountdown('{{ $promotion->expiry_date->toIso8601String() }}')">
            <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">Promotion Ends In</p>
            <div class="flex justify-center gap-6 text-2xl font-bold text-brand">
                <div><span x-text="countdown.days">0</span><p class="text-xs text-gray-400 font-normal">Days</p></div>
                <div><span x-text="countdown.hours">0</span><p class="text-xs text-gray-400 font-normal">Hours</p></div>
                <div><span x-text="countdown.minutes">0</span><p class="text-xs text-gray-400 font-normal">Minutes</p></div>
            </div>
        </div>
    @endif

    {{-- Description --}}
    @if($promotion->description)
        <div class="card p-6 mb-8">
            <h2 class="font-bold text-lg text-gray-800 mb-2">About This Promotion</h2>
            <div class="text-gray-600 text-sm leading-relaxed">{!! nl2br(e($promotion->description)) !!}</div>
        </div>
    @endif

    {{-- Instructions --}}
    @if(!empty($promotion->instructions))
        <div class="card p-6 mb-8">
            <h2 class="font-bold text-lg text-gray-800 mb-4">How to Use the CPP</h2>
            <ol class="space-y-3">
                @foreach($promotion->instructions as $i => $step)
                    <li class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand text-white text-xs flex items-center justify-center font-bold flex-shrink-0 mt-0.5">{{ $i + 1 }}</span>
                        <span class="text-sm text-gray-600">{{ $step }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    @endif

    {{-- Search --}}
    @if($promotion->allow_search)
        <div class="card p-6">
            <h2 class="font-bold text-lg text-gray-800 mb-1">Verify Your Promotion Code</h2>
            <p class="text-sm text-gray-500 mb-4">Enter your code to check your registration and project status.</p>
            <form @submit.prevent="search()" class="flex flex-col sm:flex-row gap-3">
                <input type="text" x-model="code" placeholder="Enter Promotion Code" class="input-field flex-1 uppercase" />
                <button type="submit" class="btn-primary whitespace-nowrap" :disabled="loading">
                    <span x-show="!loading">Search</span>
                    <span x-show="loading">Searching...</span>
                </button>
            </form>

            <template x-if="message">
                <p class="text-sm text-red-500 mt-3" x-text="message"></p>
            </template>

            <div x-show="result" x-cloak class="mt-6 border-t border-gray-100 pt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
                    <div><span class="text-gray-400">Company</span><p class="font-semibold" x-text="result?.company_name"></p></div>
                    <div><span class="text-gray-400">Promotion Code</span><p class="font-semibold" x-text="result?.code"></p></div>
                    <div><span class="text-gray-400">Selected Product</span><p class="font-semibold" x-text="result?.product_name"></p></div>
                    <div><span class="text-gray-400">Development Status</span><p class="font-semibold text-brand" x-text="result?.current_status"></p></div>
                </div>
                @if($promotion->show_timeline)
                <div class="space-y-2">
                    <template x-for="step in result?.timeline || []" :key="step.key">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full flex-shrink-0"
                                 :class="step.current ? 'bg-brand ring-4 ring-brand/20' : (step.completed ? 'bg-green-500' : 'bg-gray-200')"></div>
                            <span class="text-sm" :class="step.current ? 'font-bold text-brand' : (step.completed ? 'text-gray-600' : 'text-gray-400')" x-text="step.label"></span>
                        </div>
                    </template>
                </div>
                @endif
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function cppShow() {
    return {
        code: '',
        result: null,
        message: '',
        loading: false,
        stats: {},
        countdown: { days: 0, hours: 0, minutes: 0 },
        async search() {
            if (!this.code.trim()) return;
            this.loading = true;
            this.message = '';
            this.result = null;
            try {
                const res = await fetch('{{ route('cpp.search') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ code: this.code.trim() }),
                });
                const data = await res.json();
                if (data.found) {
                    this.result = data;
                } else {
                    this.message = data.message || 'No registration found for that code.';
                }
            } catch (e) {
                this.message = 'Something went wrong. Please try again.';
            } finally {
                this.loading = false;
            }
        },
        startCountdown(expiryIso) {
            const expiry = new Date(expiryIso).getTime();
            const tick = () => {
                const diff = expiry - Date.now();
                if (diff <= 0) {
                    this.countdown = { days: 0, hours: 0, minutes: 0 };
                    return;
                }
                this.countdown.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                this.countdown.hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                this.countdown.minutes = Math.floor((diff / (1000 * 60)) % 60);
            };
            tick();
            setInterval(tick, 60000);
        }
    };
}
</script>
@endpush
@endsection