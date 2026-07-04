@extends('layouts.admin')
@section('title', 'CPP Dashboard')

@section('content')

<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Total Promotions</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalPromotions }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Active Promotions</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ $activePromotions }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Expired / Closed</p>
        <p class="text-2xl font-bold text-red-500 mt-1">{{ $expiredPromotions }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Clients Registered</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalClients }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Remaining Slots</p>
        <p class="text-2xl font-bold text-brand mt-1">{{ $remainingSlots }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Promotion Products</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $promotionProducts }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">Completed Projects</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ $completedProjects }}</p>
    </div>
    <div class="stat-card">
        <p class="text-gray-500 text-sm">In Progress / Pending</p>
        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $inProgressProjects }} / {{ $pendingProjects }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card p-5">
        <h2 class="font-bold text-gray-800 mb-4">Registrations per Promotion</h2>
        <canvas id="chartPerPromotion" height="220"></canvas>
    </div>
    <div class="card p-5">
        <h2 class="font-bold text-gray-800 mb-4">Daily Registrations (Last 30 Days)</h2>
        <canvas id="chartDaily" height="220"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card p-5">
        <h2 class="font-bold text-gray-800 mb-4">Product Selection Statistics</h2>
        @if($productStats->isEmpty())
            <p class="text-gray-400 text-sm py-16 text-center">No registrations yet.</p>
        @else
            <canvas id="chartProducts" height="220"></canvas>
        @endif
    </div>
    <div class="card p-5">
        <h2 class="font-bold text-gray-800 mb-4">Status Breakdown</h2>
        @if($statusBreakdown->isEmpty())
            <p class="text-gray-400 text-sm py-16 text-center">No registrations yet.</p>
        @else
            <canvas id="chartStatus" height="220"></canvas>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('chartPerPromotion'), {
        type: 'bar',
        data: {
            labels: @json($registrationsPerPromotion->pluck('title')),
            datasets: [{ label: 'Registrations', data: @json($registrationsPerPromotion->pluck('clients_count')), backgroundColor: '#1c3f6e' }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById('chartDaily'), {
        type: 'line',
        data: {
            labels: @json($dailyRegistrations->pluck('date')),
            datasets: [{ label: 'Registrations', data: @json($dailyRegistrations->pluck('count')), borderColor: '#3b82f6', tension: 0.3 }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    @if($productStats->isNotEmpty())
    new Chart(document.getElementById('chartProducts'), {
        type: 'pie',
        data: {
            labels: @json($productStats->pluck('product.name')),
            datasets: [{ data: @json($productStats->pluck('count')), backgroundColor: ['#1c3f6e','#3b82f6','#f59e0b','#10b981','#ef4444','#8b5cf6','#ec4899','#14b8a6'] }]
        }
    });
    @endif

    @if($statusBreakdown->isNotEmpty())
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: @json($statusBreakdown->keys()),
            datasets: [{ data: @json($statusBreakdown->values()), backgroundColor: ['#f59e0b','#3b82f6','#8b5cf6','#ec4899','#14b8a6','#10b981','#1c3f6e','#ef4444','#6366f1','#84cc16'] }]
        }
    });
    @endif
});
</script>
@endpush
@endsection
