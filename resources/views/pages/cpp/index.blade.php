@extends('layouts.app')
@section('title', 'Client Promotions Portal')

@section('content')
<div class="bg-brand-dark text-white py-14">
    <div class="max-w-screen-xl mx-auto px-4 text-center">
        <h1 class="text-3xl sm:text-4xl font-bold mb-3">Client Promotions Portal</h1>
        <p class="text-blue-200 max-w-2xl mx-auto">
            Track your registration, verify your promotion code, and follow your project's progress —
            all in one place.
        </p>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 -mt-8 mb-12" x-data="cppSearch()">
    {{-- Global code search --}}
    <div class="card p-6 mb-10">
        <h2 class="font-bold text-lg text-gray-800 mb-1">Verify Your Promotion Code</h2>
        <p class="text-sm text-gray-500 mb-4">Enter the code you received after checkout to check your registration status.</p>
        <form @submit.prevent="search()" class="flex flex-col sm:flex-row gap-3">
            <input type="text" x-model="code" placeholder="Enter Promotion Code (e.g. CPP-JUL26-0001)"
                class="input-field flex-1 uppercase" />
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
                <div><span class="text-gray-400">Promotion</span><p class="font-semibold" x-text="result?.promotion_title"></p></div>
                <div><span class="text-gray-400">Selected Product</span><p class="font-semibold" x-text="result?.product_name"></p></div>
                <div><span class="text-gray-400">Development Status</span><p class="font-semibold text-brand" x-text="result?.current_status"></p></div>
            </div>
            <div class="space-y-2">
                <template x-for="step in result?.timeline || []" :key="step.key">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full flex-shrink-0"
                             :class="step.current ? 'bg-brand ring-4 ring-brand/20' : (step.completed ? 'bg-green-500' : 'bg-gray-200')"></div>
                        <span class="text-sm" :class="step.current ? 'font-bold text-brand' : (step.completed ? 'text-gray-600' : 'text-gray-400')" x-text="step.label"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 pb-16">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Current Promotions</h2>

    @if($promotions->isEmpty())
        <p class="text-gray-500">There are no promotions available right now. Please check back soon.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($promotions as $promo)
                @php $status = $promo->effective_status; @endphp
                <a href="{{ route('cpp.show', $promo) }}" class="card overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        @if($promo->banner_image)
                            <img src="{{ asset('storage/' . $promo->banner_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="{{ $promo->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-brand to-brand-dark text-white font-bold text-lg">{{ $promo->title }}</div>
                        @endif
                        <span class="absolute top-3 right-3 badge {{ $status === 'published' ? 'bg-green-100 text-green-800' : ($status === 'draft' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-800') }}">
                            {{ $status === 'published' ? 'OPEN' : ucfirst($status) }}
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-gray-800 mb-1">{{ $promo->title }}</h3>
                        <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $promo->subtitle }}</p>
                        @if($promo->show_client_counter || $promo->show_remaining_slots)
                            <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
                                @if($promo->show_client_counter)
                                    <span>{{ $promo->registeredCount() }} registered</span>
                                @endif
                                @if($promo->show_remaining_slots && $promo->max_clients)
                                    <span class="font-semibold {{ $promo->remainingSlots() === 0 ? 'text-red-500' : 'text-brand' }}">
                                        {{ $promo->remainingSlots() === 0 ? 'FULL' : $promo->remainingSlots() . ' slots left' }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
function cppSearch() {
    return {
        code: '',
        result: null,
        message: '',
        loading: false,
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
        }
    };
}
</script>
@endpush
@endsection
