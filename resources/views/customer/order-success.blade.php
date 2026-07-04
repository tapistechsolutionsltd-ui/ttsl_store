@extends('layouts.app')
@section('title', 'Project Order Confirmed!')

@section('content')
<div class="container mx-auto px-4 py-16 max-w-2xl text-center">
    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <h1 class="text-4xl font-bold text-gray-900 mb-3">Project Order Confirmed!</h1>
    <p class="text-xl text-gray-600 mb-2">Thank you for choosing TTSolutions Limited.</p>
    <p class="text-gray-500 mb-8">Your project reference number is: <span class="font-bold text-brand text-lg">{{ $order->order_number }}</span></p>

    <div class="card p-6 text-left mb-6">
        <h2 class="font-bold text-lg mb-4">Project Order Details</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <div>
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-400">Qty: {{ $item->quantity }} × K {{ number_format($item->price, 2) }}</p>
                        @if(!empty($item->features))
                            <ul class="text-xs text-gray-400 mt-0.5">
                                @foreach($item->features as $f)
                                    <li>+ {{ $f['name'] }} (K {{ number_format($f['price'], 2) }})</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <span class="font-semibold">K {{ number_format($item->total, 2) }}</span>
                </div>
            @endforeach
        </div>
        <div class="mt-4 space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Subtotal</span>
                <span>K {{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Discount</span>
                    <span>−K {{ number_format($order->discount, 2) }}</span>
                </div>
            @endif
            <div class="flex justify-between font-bold text-base border-t pt-2">
                <span>Total</span>
                <span class="text-brand">K {{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        @if($order->development_due_date)
            <div class="mt-4 p-3 bg-indigo-50 border border-indigo-200 rounded-lg text-sm flex items-start gap-2">
                <svg class="w-4 h-4 text-indigo-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-indigo-800"><strong>Estimated Completion:</strong> {{ $order->development_due_date->format('d M Y') }}. Your project tracker will be updated as work progresses.</p>
            </div>
        @endif

        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm">
            <p class="font-semibold text-yellow-800">Payment: {{ $order->payment_method_label }}</p>
            @if($order->payment_method === 'bank_transfer')
                <p class="text-yellow-700 mt-1">Please transfer <strong>K {{ number_format($order->total, 2) }}</strong> and use <strong>{{ $order->order_number }}</strong> as your reference. Development begins once payment is verified.</p>
            @else
                <p class="text-yellow-700 mt-1">Please have <strong>K {{ number_format($order->total, 2) }}</strong> ready upon project completion and handover.</p>
            @endif
        </div>
    </div>

    @if($order->cppClients->isNotEmpty())
        @foreach($order->cppClients as $cppClient)
            <div class="card p-6 text-left mb-6 border-2 border-brand/20 bg-brand/5">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.519 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    <h2 class="font-bold text-lg text-brand">Congratulations! You qualify for our promotion</h2>
                </div>
                <p class="text-gray-600 mb-3">Your order has qualified for the <strong>{{ $cppClient->promotion->title }}</strong> promotion.</p>
                <div class="bg-white rounded-lg border border-brand/30 p-4 text-center mb-3">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Your Promotion Code</p>
                    <p class="text-2xl font-bold text-brand tracking-widest">{{ $cppClient->activeCode->code ?? 'Generating...' }}</p>
                </div>
                <p class="text-sm text-gray-500 mb-4">Please keep this code. Visit the Client Promotions Portal anytime to monitor your project's progress.</p>
                <a href="{{ route('cpp.show', $cppClient->promotion) }}" class="btn-primary inline-block">View Promotion Portal</a>
            </div>
        @endforeach
    @endif

    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('account.order.detail', $order) }}" class="btn-primary">Track My Project</a>
        <a href="{{ route('shop') }}" class="btn-secondary">Browse More Templates</a>
    </div>
</div>
@endsection
