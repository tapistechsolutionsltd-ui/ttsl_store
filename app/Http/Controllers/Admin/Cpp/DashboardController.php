<?php

namespace App\Http\Controllers\Admin\Cpp;

use App\Http\Controllers\Controller;
use App\Models\CppClient;
use App\Models\CppPromotion;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPromotions   = CppPromotion::count();
        $activePromotions  = CppPromotion::where('status', 'published')->count();
        $expiredPromotions = CppPromotion::whereIn('status', ['expired', 'closed'])->count();
        $totalClients      = CppClient::count();
        $remainingSlots    = CppPromotion::where('status', 'published')->get()
            ->sum(fn($p) => $p->remainingSlots() ?? 0);
        $promotionProducts = Product::where('cpp_enabled', true)->count();

        $completedProjects  = CppClient::where('current_timeline_status', 'completed')->count();
        $inProgressProjects = CppClient::whereNotIn('current_timeline_status', ['application_received', 'completed'])->count();
        $pendingProjects    = CppClient::where('current_timeline_status', 'application_received')->count();

        $registrationsPerPromotion = CppPromotion::withCount('clients')->orderByDesc('clients_count')->take(8)->get();

        $dailyRegistrations = CppClient::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $productStats = CppClient::select('product_id', DB::raw('count(*) as count'))
            ->groupBy('product_id')
            ->with('product:id,name')
            ->orderByDesc('count')
            ->take(8)
            ->get();

        $statusBreakdown = CppClient::select('current_timeline_status', DB::raw('count(*) as count'))
            ->groupBy('current_timeline_status')
            ->pluck('count', 'current_timeline_status');

        return view('admin.cpp.dashboard', compact(
            'totalPromotions', 'activePromotions', 'expiredPromotions', 'totalClients',
            'remainingSlots', 'promotionProducts', 'completedProjects', 'inProgressProjects', 'pendingProjects',
            'registrationsPerPromotion', 'dailyRegistrations', 'productStats', 'statusBreakdown'
        ));
    }
}
