@extends('layouts.app')
@section('title', 'Project '.$order->order_number)

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('account.orders') }}" class="text-blue-200 hover:text-white">← My Projects</a>
            <span class="text-blue-200">/</span>
            <h1 class="text-2xl font-bold">{{ $order->order_number }}</h1>
        </div>
        <p class="text-blue-100 mt-1">Ordered on {{ $order->created_at->format('d M Y, H:i') }}</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8 max-w-4xl">

    {{-- Status banner --}}
    <div class="card p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Project Status</p>
                <span class="badge {{ $order->status_badge_class }} mt-1 text-sm">{{ $order->status_label }}</span>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Payment</p>
                <span class="badge {{ $order->payment_badge_class }} mt-1 text-sm">{{ ucfirst($order->payment_status) }}</span>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Payment Method</p>
                <p class="text-sm font-semibold mt-1">{{ $order->payment_method_label }}</p>
            </div>
        </div>
        @if($order->tracking_number)
            <div class="text-right">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Project Reference</p>
                <p class="font-bold text-brand">{{ $order->tracking_number }}</p>
            </div>
        @endif
    </div>

    {{-- Development Timeline / Countdown --}}
    @php $progress = $order->development_progress; @endphp
    @if($progress['has_timeline'])
        <div class="card p-5 mb-6 border-l-4 {{ $progress['is_complete'] ? 'border-green-500 bg-green-50/30' : ($progress['is_overdue'] ? 'border-red-400 bg-red-50/30' : 'border-brand bg-brand/5') }}">
            <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 {{ $progress['is_complete'] ? 'text-green-600' : ($progress['is_overdue'] ? 'text-red-500' : 'text-brand') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="font-bold text-gray-900">Development Timeline</h3>
                </div>
                @if($progress['is_complete'])
                    <span class="badge bg-green-100 text-green-800">Project Completed</span>
                @elseif($progress['is_overdue'])
                    <span class="badge bg-red-100 text-red-700">Overdue — Please Contact Us</span>
                @else
                    <span class="text-sm font-semibold text-brand">{{ $progress['remaining'] }} day{{ $progress['remaining'] != 1 ? 's' : '' }} remaining</span>
                @endif
            </div>

            <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                <span>Project Start: {{ $order->created_at->format('d M Y') }}</span>
                <span>Due: {{ $progress['due_date'] }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 mb-2 overflow-hidden">
                <div class="h-3 rounded-full transition-all duration-500 {{ $progress['is_complete'] ? 'bg-green-500' : ($progress['is_overdue'] ? 'bg-red-400' : 'bg-brand') }}"
                     style="width: {{ $progress['percent'] }}%"></div>
            </div>
            <p class="text-xs text-gray-400">{{ $progress['percent'] }}% of development period elapsed &bull; {{ $progress['elapsed'] }} of {{ $progress['total_days'] }} days</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Project items --}}
        <div class="md:col-span-2 card overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Ordered Products</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($order->items as $item)
                    <div class="flex gap-4 p-4">
                        @if($item->product)
                            <a href="{{ route('shop.product', $item->product->slug) }}">
                                <img src="{{ $item->product->primary_image_url }}" alt=""
                                     class="w-16 h-16 object-cover rounded-lg flex-shrink-0"
                                     onerror="this.src='https://via.placeholder.com/64?text=N/A'" />
                            </a>
                        @else
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 flex-shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800">{{ $item->product_name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">License: {{ $item->product_sku }}</p>
                            <p class="text-sm text-gray-500 mt-1">K {{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                            @if(!empty($item->features))
                                <ul class="text-xs text-gray-400 mt-1">
                                    @foreach($item->features as $f)
                                        <li>+ {{ $f['name'] }} (K {{ number_format($f['price'], 2) }})</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="font-bold text-brand whitespace-nowrap">K {{ number_format($item->total, 2) }}</div>
                    </div>
                @endforeach
            </div>
            <div class="p-5 border-t bg-gray-50">
                <div class="space-y-2 text-sm max-w-xs ml-auto">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span>K {{ number_format($order->subtotal, 2) }}</span></div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-green-600"><span>Discount</span><span>−K {{ number_format($order->discount, 2) }}</span></div>
                    @endif
                    <div class="flex justify-between font-bold text-lg border-t pt-2"><span>Total</span><span class="text-brand">K {{ number_format($order->total, 2) }}</span></div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- Client Information --}}
            <div class="card p-5">
                <h3 class="font-bold text-gray-800 mb-3">Client Information</h3>
                @php $addr = $order->shipping_address; @endphp
                <p class="font-medium text-sm">{{ $addr['full_name'] ?? '' }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $addr['address'] ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $addr['city'] ?? '' }}, {{ $addr['province'] ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $addr['country'] ?? '' }}</p>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> {{ $addr['phone'] ?? '' }}</p>
            </div>

            {{-- Attached Files --}}
            @if($order->attachment_original_name)
                <div class="card p-5 border border-brand/20">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Project Files
                    </h3>
                    <div class="flex items-center gap-2 p-2.5 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span class="text-xs text-gray-600 truncate">{{ $order->attachment_original_name }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">Submitted with your order</p>
                </div>
            @endif

            {{-- Payment info --}}
            @if($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
                <div class="card p-5 border-2 border-yellow-300 bg-yellow-50">
                    <h3 class="font-bold text-yellow-800 mb-2">⏳ Payment Pending</h3>
                    <p class="text-sm text-yellow-700">Please transfer <strong>K {{ number_format($order->total, 2) }}</strong> to:</p>
                    <div class="mt-2 text-sm space-y-1">
                        <p><strong>BSP:</strong> 1234567890</p>
                        <p><strong>Kina Bank:</strong> 0987654321</p>
                        <p><strong>Reference:</strong> {{ $order->order_number }}</p>
                    </div>
                </div>
            @endif

            @if($order->notes)
                <div class="card p-5">
                    <h3 class="font-bold text-gray-800 mb-2">Your Project Notes</h3>
                    <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
