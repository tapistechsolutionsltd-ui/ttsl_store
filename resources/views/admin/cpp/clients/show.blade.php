@extends('layouts.admin')
@section('title', 'Client Detail')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.cpp.clients.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-brand">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Clients
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">

        <div class="card p-6">
            <h2 class="font-bold text-gray-800 mb-4">Client Information</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-400">Company</span><p class="font-medium">{{ $client->company_name ?? '—' }}</p></div>
                <div><span class="text-gray-400">Customer</span><p class="font-medium">{{ $client->user->name ?? '—' }} ({{ $client->user->email ?? '' }})</p></div>
                <div><span class="text-gray-400">Promotion</span><p class="font-medium">{{ $client->promotion->title ?? '—' }}</p></div>
                <div><span class="text-gray-400">Product</span><p class="font-medium">{{ $client->product->name ?? '—' }}</p></div>
                <div><span class="text-gray-400">Order</span><p class="font-medium">
                    <a href="{{ route('admin.orders.show', $client->order_id) }}" class="text-brand hover:underline">{{ $client->order->order_number ?? '—' }}</a>
                </p></div>
                <div><span class="text-gray-400">Registered</span><p class="font-medium">{{ $client->created_at->format('d M Y, H:i') }}</p></div>
            </div>
        </div>

        <div class="card p-6">
            <h2 class="font-bold text-gray-800 mb-4">Update Timeline Status</h2>
            <form method="POST" action="{{ route('admin.cpp.clients.timeline', $client) }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="input-field">
                            @foreach(\App\Models\CppClient::TIMELINE_STATUSES as $key => $label)
                                <option value="{{ $key }}" {{ $client->current_timeline_status === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Progress %</label>
                        <input type="number" name="progress_percent" min="0" max="100" value="{{ $client->progress_percent }}" class="input-field" />
                    </div>
                </div>
                <div>
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="3" class="input-field" placeholder="Optional update note visible in the internal log"></textarea>
                </div>
                <button type="submit" class="btn-primary">Update Timeline</button>
            </form>
        </div>

        <div class="card p-6">
            <h2 class="font-bold text-gray-800 mb-4">Timeline History</h2>
            <div class="space-y-3">
                @forelse($client->timelineLogs as $log)
                    <div class="flex items-start gap-3 border-b border-gray-50 pb-3">
                        <div class="w-2 h-2 rounded-full bg-brand mt-1.5 flex-shrink-0"></div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">{{ $log->status_label }} @if($log->progress_percent !== null)<span class="text-gray-400 font-normal">({{ $log->progress_percent }}%)</span>@endif</p>
                            @if($log->notes)<p class="text-sm text-gray-500">{{ $log->notes }}</p>@endif
                            <p class="text-xs text-gray-400">{{ $log->created_at->format('d M Y, H:i') }} @if($log->admin) — {{ $log->admin->name }} @endif</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">No timeline updates yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div class="card p-5">
            <h2 class="font-bold text-gray-800 mb-4">Promotion Codes</h2>
            <div class="space-y-3">
                @foreach($client->codes as $code)
                    <div class="border border-gray-100 rounded-lg p-3">
                        <p class="font-mono font-bold text-brand">{{ $code->code }}</p>
                        <p class="text-xs text-gray-400 mb-2">{{ ucfirst($code->status) }} · {{ $code->generated_at->format('d M Y') }}</p>
                        <div class="flex gap-2">
                            @if($code->status === 'active')
                                <form method="POST" action="{{ route('admin.cpp.codes.expire', $code) }}">
                                    @csrf @method('PATCH')
                                    <button class="text-xs text-yellow-600 hover:underline">Expire</button>
                                </form>
                                <form method="POST" action="{{ route('admin.cpp.codes.cancel', $code) }}">
                                    @csrf @method('PATCH')
                                    <button class="text-xs text-red-500 hover:underline">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <form method="POST" action="{{ route('admin.cpp.codes.generate', $client) }}" class="mt-3">
                @csrf
                <button class="btn-secondary btn-sm w-full">Generate New Code</button>
            </form>
        </div>

        <div class="card p-5">
            <h2 class="font-bold text-gray-800 mb-4">Client Settings</h2>
            <form method="POST" action="{{ route('admin.cpp.clients.update', $client) }}" class="space-y-3">
                @csrf @method('PUT')
                <div>
                    <label class="form-label">Company Name (public)</label>
                    <input type="text" name="company_name" value="{{ $client->company_name }}" class="input-field" />
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $client->is_active ? 'checked' : '' }} class="rounded text-brand" />
                    <span class="text-sm text-gray-700">Active</span>
                </label>
                <button type="submit" class="btn-primary w-full">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
