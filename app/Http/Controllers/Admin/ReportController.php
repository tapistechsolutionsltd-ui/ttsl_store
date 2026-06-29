<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $orders = Order::with(['user', 'items'])
            ->whereBetween('created_at', [$from, $to . ' 23:59:59'])
            ->where('payment_status', 'paid')
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders  = $orders->count();
        $avgOrder     = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $dailySales = $orders->groupBy(fn($o) => $o->created_at->format('Y-m-d'))
            ->map(fn($group) => $group->sum('total'));

        return view('admin.reports.sales', compact('orders', 'totalRevenue', 'totalOrders', 'avgOrder', 'dailySales', 'from', 'to'));
    }

    public function salesDownload(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $orders = Order::with(['user', 'items.product'])
            ->whereBetween('created_at', [$from, $to . ' 23:59:59'])
            ->where('payment_status', 'paid')
            ->orderBy('created_at')
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders  = $orders->count();
        $avgOrder     = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $filename = 'sales-report-' . $from . '-to-' . $to . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($orders, $from, $to, $totalRevenue, $totalOrders, $avgOrder) {
            $handle = fopen('php://output', 'w');

            // Report header
            fputcsv($handle, ['NextGen Store PNG — Sales Report']);
            fputcsv($handle, ['Period', $from . ' to ' . $to]);
            fputcsv($handle, ['Generated', now()->format('d M Y H:i T')]);
            fputcsv($handle, []);

            // Summary
            fputcsv($handle, ['SUMMARY']);
            fputcsv($handle, ['Total Revenue (K)', number_format($totalRevenue, 2)]);
            fputcsv($handle, ['Total Orders', $totalOrders]);
            fputcsv($handle, ['Average Order Value (K)', number_format($avgOrder, 2)]);
            fputcsv($handle, []);

            // Daily breakdown
            $dailySales = $orders->groupBy(fn($o) => $o->created_at->format('Y-m-d'));
            if ($dailySales->isNotEmpty()) {
                fputcsv($handle, ['DAILY BREAKDOWN']);
                fputcsv($handle, ['Date', 'Orders', 'Revenue (K)']);
                foreach ($dailySales as $date => $dayOrders) {
                    fputcsv($handle, [
                        $date,
                        $dayOrders->count(),
                        number_format($dayOrders->sum('total'), 2),
                    ]);
                }
                fputcsv($handle, []);
            }

            // Order details
            fputcsv($handle, ['ORDER DETAILS']);
            fputcsv($handle, ['Order #', 'Customer', 'Email', 'Date', 'Line Items', 'Payment Status', 'Total (K)']);
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->user->name ?? 'Guest',
                    $order->user->email ?? '',
                    $order->created_at->format('d M Y H:i'),
                    $order->items->count(),
                    ucfirst($order->payment_status),
                    number_format($order->total, 2),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function products(Request $request)
    {
        $products = Product::withCount(['orderItems as units_sold' => fn($q) => $q->select(DB::raw('sum(quantity)'))])
            ->withSum('orderItems', 'total')
            ->orderByDesc('units_sold')
            ->paginate(20);

        return view('admin.reports.products', compact('products'));
    }

    public function inventory()
    {
        $lowStock    = Product::active()->where('stock', '<=', 10)->orderBy('stock')->get();
        $outOfStock  = Product::active()->where('stock', 0)->get();
        $allProducts = Product::active()->orderByDesc('stock')->paginate(20);

        return view('admin.reports.inventory', compact('lowStock', 'outOfStock', 'allProducts'));
    }

    public function salesPdf(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $orders = Order::with(['user', 'items'])
            ->whereBetween('created_at', [$from, $to . ' 23:59:59'])
            ->where('payment_status', 'paid')
            ->orderBy('created_at')
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders  = $orders->count();
        $avgOrder     = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $dailySales = $orders->groupBy(fn($o) => $o->created_at->format('Y-m-d'));

        $pdf = Pdf::loadView('admin.reports.sales-pdf', compact(
            'orders', 'totalRevenue', 'totalOrders', 'avgOrder', 'dailySales', 'from', 'to'
        ))->setPaper('a4', 'portrait');

        $filename = 'TTSL-Sales-Report-' . $from . '-to-' . $to . '.pdf';

        return $pdf->download($filename);
    }

    public function customers()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum(['orders' => fn($q) => $q->where('payment_status', 'paid')], 'total')
            ->orderByDesc('orders_sum_total')
            ->paginate(20);

        return view('admin.reports.customers', compact('customers'));
    }

    public function customersDownload()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum(['orders' => fn($q) => $q->where('payment_status', 'paid')], 'total')
            ->orderByDesc('orders_sum_total')
            ->get();

        $filename = 'TTSL-Customer-Report-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($customers) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // Company header
            fputcsv($handle, ['TTSolutions Limited (TTSL) — Customer Report']);
            fputcsv($handle, ['Time Square Bldg, Level 4, Wardstrip Rd, Gordons, NCD, Papua New Guinea']);
            fputcsv($handle, ['Phone: +675 7224 3900  |  Email: tapistechsolutionsltd@gmail.com']);
            fputcsv($handle, ['Generated', now()->format('d M Y H:i T')]);
            fputcsv($handle, ['Total Customers', $customers->count()]);
            fputcsv($handle, []);

            // Summary
            fputcsv($handle, ['CUSTOMER SUMMARY']);
            fputcsv($handle, ['Total Registered Customers', $customers->count()]);
            fputcsv($handle, ['Total Combined Spending (K)', number_format($customers->sum('orders_sum_total'), 2)]);
            fputcsv($handle, ['Total Combined Orders', $customers->sum('orders_count')]);
            fputcsv($handle, []);

            // Column headers
            fputcsv($handle, ['#', 'Customer Name', 'Email Address', 'Phone', 'Total Orders', 'Total Spent (K)', 'Member Since']);

            foreach ($customers as $i => $c) {
                fputcsv($handle, [
                    $i + 1,
                    $c->name,
                    $c->email,
                    $c->phone ?? 'N/A',
                    $c->orders_count,
                    number_format($c->orders_sum_total ?? 0, 2),
                    $c->created_at->format('d M Y'),
                ]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['--- End of Report ---']);
            fputcsv($handle, ['© ' . date('Y') . ' TTSolutions Limited. All rights reserved.']);

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
