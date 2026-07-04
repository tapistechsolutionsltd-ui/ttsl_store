<?php

namespace App\Http\Controllers\Admin\Cpp;

use App\Http\Controllers\Controller;
use App\Models\CppClient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function registrations(Request $request)
    {
        $from = $request->from ?? now()->subDays(30)->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $clients = CppClient::with(['promotion', 'product', 'user', 'activeCode'])
            ->whereBetween('created_at', [$from, $to . ' 23:59:59'])
            ->latest()
            ->get();

        $perPromotion = $clients->groupBy(fn($c) => $c->promotion->title ?? 'Unknown')->map->count();
        $perProduct   = $clients->groupBy(fn($c) => $c->product->name ?? 'Unknown')->map->count();
        $statusBreakdown = $clients->groupBy('current_timeline_status')->map->count();

        $totalOrders = DB::table('orders')->whereBetween('created_at', [$from, $to . ' 23:59:59'])->count();
        $conversionRate = $totalOrders > 0 ? round(($clients->count() / $totalOrders) * 100, 1) : 0;

        return view('admin.cpp.reports.registrations', compact(
            'clients', 'perPromotion', 'perProduct', 'statusBreakdown', 'conversionRate', 'from', 'to'
        ));
    }

    public function registrationsDownload(Request $request)
    {
        $from = $request->from ?? now()->subDays(30)->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $clients = CppClient::with(['promotion', 'product', 'user', 'activeCode'])
            ->whereBetween('created_at', [$from, $to . ' 23:59:59'])
            ->orderBy('created_at')
            ->get();

        $filename = 'cpp-registrations-' . $from . '-to-' . $to . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($clients, $from, $to) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['TTSolutions Limited — Client Promotions Portal Registrations']);
            fputcsv($handle, ['Period', $from . ' to ' . $to]);
            fputcsv($handle, ['Generated', now()->format('d M Y H:i T')]);
            fputcsv($handle, []);
            fputcsv($handle, ['Code', 'Company', 'Customer', 'Promotion', 'Product', 'Status', 'Registered']);

            foreach ($clients as $c) {
                fputcsv($handle, [
                    $c->activeCode->code ?? '',
                    $c->company_name ?? '',
                    $c->user->name ?? '',
                    $c->promotion->title ?? '',
                    $c->product->name ?? '',
                    $c->current_timeline_label,
                    $c->created_at->format('d M Y H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function registrationsPdf(Request $request)
    {
        $from = $request->from ?? now()->subDays(30)->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $clients = CppClient::with(['promotion', 'product', 'user', 'activeCode'])
            ->whereBetween('created_at', [$from, $to . ' 23:59:59'])
            ->orderBy('created_at')
            ->get();

        $pdf = Pdf::loadView('admin.cpp.reports.registrations-pdf', compact('clients', 'from', 'to'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('TTSL-CPP-Registrations-' . $from . '-to-' . $to . '.pdf');
    }
}
