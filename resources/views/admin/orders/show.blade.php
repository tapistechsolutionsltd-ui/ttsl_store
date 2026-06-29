@extends('layouts.admin')
@section('title', 'Project '.$order->order_number)

@section('content')
{{-- Page Header --}}
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800">{{ $order->order_number }}</h1>
        <p class="text-sm text-gray-400 mt-0.5">Placed {{ $order->created_at->format('d M Y \a\t H:i') }}</p>
    </div>
    <a href="{{ route('admin.orders.client.pdf', $order) }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
        Download Client Brief PDF
    </a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-5">

        {{-- Development Timeline --}}
        @php $progress = $order->development_progress; @endphp
        @if($progress['has_timeline'])
            <div class="card p-5 border-l-4 {{ $progress['is_complete'] ? 'border-green-500' : ($progress['is_overdue'] ? 'border-red-400' : 'border-brand') }}">
                <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Development Timeline
                    </h3>
                    @if($progress['is_complete'])
                        <span class="badge bg-green-100 text-green-800">Completed</span>
                    @elseif($progress['is_overdue'])
                        <span class="badge bg-red-100 text-red-700">⚠ Overdue by {{ abs($progress['remaining']) }} days</span>
                    @else
                        <span class="text-sm font-semibold text-brand">{{ $progress['remaining'] }} day{{ $progress['remaining'] != 1 ? 's' : '' }} left</span>
                    @endif
                </div>
                <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                    <span>Start: {{ $order->created_at->format('d M Y') }}</span>
                    <span>Due: {{ $progress['due_date'] }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                    <div class="h-2.5 rounded-full {{ $progress['is_complete'] ? 'bg-green-500' : ($progress['is_overdue'] ? 'bg-red-400' : 'bg-brand') }}"
                         style="width: {{ $progress['percent'] }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ $progress['percent'] }}% elapsed &bull; {{ $progress['elapsed'] }}/{{ $progress['total_days'] }} days</p>
            </div>
        @endif

        {{-- Items --}}
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Project Items</h2>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50"><tr>
                    <th class="table-header">Product / Template</th>
                    <th class="table-header">License #</th>
                    <th class="table-header">Qty</th>
                    <th class="table-header">Price</th>
                    <th class="table-header">Total</th>
                </tr></thead>
                <tbody class="divide-y">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="table-cell font-medium">
                                {{ $item->product_name }}
                                @if(!empty($item->features))
                                    <ul class="text-xs text-gray-400 font-normal mt-1">
                                        @foreach($item->features as $f)
                                            <li>+ {{ $f['name'] }} (K {{ number_format($f['price'], 2) }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td class="table-cell text-gray-400 font-mono text-xs">{{ $item->product_sku }}</td>
                            <td class="table-cell">{{ $item->quantity }}</td>
                            <td class="table-cell">K {{ number_format($item->price, 2) }}</td>
                            <td class="table-cell font-bold">K {{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-5 border-t bg-gray-50">
                <div class="flex justify-end">
                    <div class="w-48 space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span>K {{ number_format($order->subtotal, 2) }}</span></div>
                        @if($order->discount > 0)
                            <div class="flex justify-between text-green-600"><span>Discount</span><span>−K {{ number_format($order->discount, 2) }}</span></div>
                        @endif
                        <div class="flex justify-between font-bold text-base border-t pt-2"><span>Total</span><span class="text-brand">K {{ number_format($order->total, 2) }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Client Information --}}
        @php $addr = $order->shipping_address ?? []; @endphp
        <div class="card p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Client Information
                </h2>
            </div>

            {{-- Contact Details --}}
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Contact Details</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Full Name</p>
                    <p class="font-semibold text-gray-800 text-sm">{{ $addr['full_name'] ?? '—' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Email Address</p>
                    <p class="font-semibold text-brand text-sm break-all">{{ $order->client_email ?? ($order->user->email ?? '—') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Phone Number</p>
                    <p class="font-semibold text-gray-800 text-sm">{{ $addr['phone'] ?? '—' }}</p>
                </div>
                @if($order->organisation)
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Company / Organisation</p>
                    <p class="font-semibold text-gray-800 text-sm">{{ $order->organisation }}</p>
                </div>
                @endif
                <div class="bg-gray-50 rounded-lg p-3 sm:col-span-2">
                    <p class="text-xs text-gray-400 mb-0.5">Address</p>
                    <p class="font-medium text-gray-700 text-sm">
                        {{ $addr['address'] ?? '' }}{{ ($addr['city'] ?? '') ? ', ' . $addr['city'] : '' }}{{ ($addr['province'] ?? '') ? ', ' . $addr['province'] : '' }}
                    </p>
                    <p class="text-gray-500 text-sm">{{ $addr['country'] ?? '' }}</p>
                </div>
            </div>

            {{-- Project & Technical Details --}}
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 border-t pt-3">Project &amp; Technical Details</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="bg-blue-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-1">First Website?</p>
                    @if($order->is_first_website === null)
                        <span class="text-sm text-gray-400 italic">Not specified</span>
                    @elseif($order->is_first_website)
                        <span class="inline-flex items-center gap-1 text-xs font-bold bg-green-100 text-green-700 px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Yes — First Website
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-xs font-bold bg-orange-100 text-orange-700 px-2.5 py-1 rounded-full">
                            Has an Existing Site
                        </span>
                    @endif
                </div>
                <div class="bg-blue-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Existing Domain</p>
                    @if($order->existing_domain)
                        <p class="font-semibold text-brand text-sm">{{ $order->existing_domain }}</p>
                    @else
                        <p class="text-sm text-gray-400 italic">None / N/A</p>
                    @endif
                </div>
                <div class="bg-blue-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Website Type</p>
                    <p class="font-semibold text-gray-800 text-sm">{{ $order->website_type ?: '—' }}</p>
                </div>
                <div class="bg-blue-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Preferred Colour Scheme</p>
                    <p class="font-semibold text-gray-800 text-sm">{{ $order->preferred_colors ?: '—' }}</p>
                </div>
                @if($order->social_media_links)
                <div class="bg-blue-50 rounded-lg p-3 sm:col-span-2">
                    <p class="text-xs text-gray-400 mb-1">Social Media Links</p>
                    <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $order->social_media_links }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Client Attachment --}}
        <div class="card p-5 {{ $order->attachment_path ? 'border-brand/30 border' : '' }}">
            <h2 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                Client Project Files
            </h2>
            @if($order->attachment_path)
                <div class="flex items-center justify-between p-3 bg-brand/5 rounded-xl border border-brand/20">
                    <div class="flex items-center gap-2 min-w-0">
                        <svg class="w-6 h-6 text-brand flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $order->attachment_original_name }}</p>
                            <p class="text-xs text-gray-400">Submitted {{ $order->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.orders.attachment', $order) }}"
                       class="flex-shrink-0 flex items-center gap-1.5 text-sm font-semibold text-white bg-brand hover:bg-brand-dark px-4 py-2 rounded-lg transition-colors ml-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download
                    </a>
                </div>
            @else
                <div class="p-4 bg-gray-50 rounded-xl text-center text-gray-400 text-sm">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    No files attached to this order.
                </div>
            @endif
        </div>

        @if($order->notes)
            <div class="card p-5">
                <h2 class="font-bold text-gray-800 mb-2">Client Project Notes</h2>
                <p class="text-gray-600 text-sm">{{ $order->notes }}</p>
            </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">

        {{-- Status Update --}}
        <div class="card p-5">
            <h2 class="font-bold text-gray-800 mb-4">Update Project Status</h2>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-3">
                @csrf @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Project Status</label>
                    <select name="order_status" class="input-field text-sm">
                        <option value="pending"    {{ $order->order_status === 'pending'    ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>In Development</option>
                        <option value="paid"       {{ $order->order_status === 'paid'       ? 'selected' : '' }}>Payment Confirmed</option>
                        <option value="shipped"    {{ $order->order_status === 'shipped'    ? 'selected' : '' }}>In Progress</option>
                        <option value="delivered"  {{ $order->order_status === 'delivered'  ? 'selected' : '' }}>Project Completed</option>
                        <option value="cancelled"  {{ $order->order_status === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                        <option value="refunded"   {{ $order->order_status === 'refunded'   ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                    <select name="payment_status" class="input-field text-sm">
                        @foreach(['pending','paid','failed','refunded'] as $s)
                            <option value="{{ $s }}" {{ $order->payment_status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Development Due Date</label>
                    <input type="date" name="development_due_date"
                        value="{{ $order->development_due_date?->format('Y-m-d') }}"
                        class="input-field text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Project Reference / Tracking</label>
                    <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" class="input-field text-sm"
                        placeholder="Internal project reference..." />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Admin Notes</label>
                    <textarea name="admin_notes" rows="3" class="input-field text-sm"
                        placeholder="Internal notes about this project...">{{ $order->admin_notes }}</textarea>
                </div>
                <button type="submit" class="btn-primary w-full">Update Project</button>
            </form>
        </div>

        {{-- Order Info --}}
        <div class="card p-5 text-sm space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-500">Order Date</span>
                <span class="font-medium">{{ $order->created_at->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Client</span>
                <a href="{{ route('admin.customers.show', $order->user) }}" class="text-brand hover:underline font-medium">{{ $order->user->name }}</a>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Payment</span>
                <span class="font-medium">{{ $order->payment_method_label }}</span>
            </div>
            @if($order->development_due_date)
                <div class="flex justify-between">
                    <span class="text-gray-500">Due Date</span>
                    <span class="font-medium">{{ $order->development_due_date->format('d M Y') }}</span>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
