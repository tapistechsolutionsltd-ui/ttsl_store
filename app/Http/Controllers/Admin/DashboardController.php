<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue   = Order::where('payment_status', 'paid')->sum('total');
        $totalOrders    = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts  = Product::where('status', 'active')->count();

        $recentOrders = Order::with('user')->latest()->take(10)->get();

        $lowStockProducts = Product::where('stock', '<=', 5)
            ->where('status', 'active')
            ->take(10)
            ->get();

        $monthlySales = Order::where('payment_status', 'paid')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->get();

        $ordersByStatus = Order::select('order_status', DB::raw('count(*) as count'))
            ->groupBy('order_status')
            ->pluck('count', 'order_status');

        $topProducts = Product::withCount(['orderItems as total_sold' => function ($q) {
            $q->select(DB::raw('sum(quantity)'));
        }])->orderByDesc('total_sold')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalCustomers', 'totalProducts',
            'recentOrders', 'lowStockProducts', 'monthlySales', 'ordersByStatus', 'topProducts'
        ));
    }

    public function badges()
    {
        return response()->json([
            'orders'    => Order::where('order_status', 'pending')->count(),
            'customers' => User::where('role', 'customer')
                               ->whereDate('created_at', today())
                               ->count(),
            'inventory' => Product::where('stock', '<=', 5)
                                  ->where('stock', '>', 0)
                                  ->where('status', 'active')
                                  ->count(),
            'out_of_stock' => Product::where('stock', 0)
                                     ->where('status', 'active')
                                     ->count(),
        ]);
    }
}
