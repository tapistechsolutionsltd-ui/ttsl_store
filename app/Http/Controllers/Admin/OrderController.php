<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        if ($request->filled('payment')) {
            $query->where('payment_status', $request->payment);
        }
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status'         => 'required|in:pending,processing,paid,shipped,delivered,cancelled,refunded',
            'payment_status'       => 'required|in:pending,paid,failed,refunded',
            'tracking_number'      => 'nullable|string|max:100',
            'admin_notes'          => 'nullable|string|max:1000',
            'development_due_date' => 'nullable|date',
        ]);

        $order->update($request->only(
            'order_status', 'payment_status', 'tracking_number', 'admin_notes', 'development_due_date'
        ));

        return back()->with('success', 'Project status updated successfully.');
    }

    public function destroyBulk(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:orders,id',
        ]);

        $count = Order::whereIn('id', $request->ids)->delete();

        return back()->with('success', "Deleted {$count} order(s) successfully.");
    }

    public function downloadAttachment(Order $order)
    {
        if (!$order->attachment_path || !Storage::disk('public')->exists($order->attachment_path)) {
            return back()->with('error', 'Attachment file not found.');
        }

        $fullPath = Storage::disk('public')->path($order->attachment_path);
        $name     = $order->attachment_original_name ?? basename($order->attachment_path);

        return response()->download($fullPath, $name);
    }

    public function clientPdf(Order $order)
    {
        $order->load(['user', 'items.product']);

        $pdf = Pdf::loadView('admin.orders.client-pdf', compact('order'))
            ->setPaper('a4', 'portrait');

        $filename = 'TTSL-Order-' . $order->order_number . '-Client-Brief.pdf';

        return $pdf->download($filename);
    }
}
