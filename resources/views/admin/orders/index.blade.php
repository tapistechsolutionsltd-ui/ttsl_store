@extends('layouts.admin')
@section('title', 'Project Orders')

@section('content')

{{-- Bulk-delete form (submitted by JS) --}}
<form id="bulk-delete-form" method="POST" action="{{ route('admin.orders.bulk-delete') }}" style="display:none;">
    @csrf
    @method('DELETE')
    <div id="bulk-delete-inputs"></div>
</form>

<div x-data="{
        selected: [],
        get allChecked() {
            return {{ $orders->count() }} > 0 && this.selected.length === {{ $orders->count() }};
        },
        get someChecked() {
            return this.selected.length > 0 && this.selected.length < {{ $orders->count() }};
        },
        toggleAll(checked) {
            this.selected = checked ? [{{ $orders->pluck('id')->join(',') }}] : [];
        },
        deleteSelected() {
            const container = document.getElementById('bulk-delete-inputs');
            container.innerHTML = '';
            this.selected.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                container.appendChild(input);
            });
            document.getElementById('bulk-delete-form').submit();
        }
     }">

    {{-- Filter form --}}
    <form method="GET" class="card p-4 mb-4 flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order / project #..."
            class="input-field py-2 text-sm flex-1 min-w-48" />
        <select name="status" class="input-field py-2 text-sm w-48">
            <option value="">All Statuses</option>
            <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>In Development</option>
            <option value="paid"       {{ request('status') === 'paid'       ? 'selected' : '' }}>Payment Confirmed</option>
            <option value="shipped"    {{ request('status') === 'shipped'    ? 'selected' : '' }}>In Progress</option>
            <option value="delivered"  {{ request('status') === 'delivered'  ? 'selected' : '' }}>Project Completed</option>
            <option value="cancelled"  {{ request('status') === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
            <option value="refunded"   {{ request('status') === 'refunded'   ? 'selected' : '' }}>Refunded</option>
        </select>
        <select name="payment" class="input-field py-2 text-sm w-36">
            <option value="">All Payments</option>
            @foreach(['pending','paid','failed','refunded'] as $s)
                <option value="{{ $s }}" {{ request('payment') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary btn-sm">Filter</button>
        <a href="{{ route('admin.orders.index') }}" class="btn-secondary btn-sm">Reset</a>
    </form>

    {{-- Bulk action toolbar: visible when at least one row is selected --}}
    <div x-show="selected.length > 0"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="mb-4 flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3"
         style="display:none;">
        <span class="text-sm font-semibold text-blue-800">
            <span x-text="selected.length"></span> order(s) selected
        </span>
        <div class="flex-1"></div>
        <button type="button"
                @click="selected = []"
                class="text-sm text-gray-500 hover:text-gray-700 px-3 py-1.5 rounded-lg hover:bg-white transition-colors">
            Clear selection
        </button>
        <button type="button"
                @click="askConfirm(
                    'Delete ' + selected.length + ' selected order(s)? This action cannot be undone.',
                    () => deleteSelected(),
                    'Delete Selected Orders'
                )"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-1.5 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Delete Selected
        </button>
    </div>

    {{-- Orders table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    {{-- Select-all checkbox --}}
                    <th class="table-header w-10">
                        <input type="checkbox"
                               class="rounded border-gray-300 text-brand cursor-pointer"
                               :checked="allChecked"
                               :indeterminate.prop="someChecked"
                               @change="toggleAll($event.target.checked)">
                    </th>
                    <th class="table-header">Project #</th>
                    <th class="table-header">Client</th>
                    <th class="table-header">Date</th>
                    <th class="table-header">Payment</th>
                    <th class="table-header">Status</th>
                    <th class="table-header">Due Date</th>
                    <th class="table-header">Total</th>
                    <th class="table-header">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors"
                        :class="selected.includes({{ $order->id }}) ? 'bg-blue-50' : ''">
                        <td class="table-cell">
                            <input type="checkbox"
                                   class="rounded border-gray-300 text-brand cursor-pointer"
                                   value="{{ $order->id }}"
                                   x-model="selected">
                        </td>
                        <td class="table-cell font-medium text-brand">{{ $order->order_number }}</td>
                        <td class="table-cell">{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="table-cell text-gray-500 text-xs">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="table-cell"><span class="badge {{ $order->payment_badge_class }}">{{ ucfirst($order->payment_status) }}</span></td>
                        <td class="table-cell"><span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span></td>
                        <td class="table-cell text-xs text-gray-500">
                            {{ $order->development_due_date ? $order->development_due_date->format('d M Y') : '—' }}
                        </td>
                        <td class="table-cell font-bold text-brand">K {{ number_format($order->total, 2) }}</td>
                        <td class="table-cell">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-brand hover:underline text-sm">View →</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-12 text-gray-400">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
        <div class="p-4 border-t">{{ $orders->links() }}</div>
    </div>

</div>
@endsection
