<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAlert;
use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with(['items.product'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $user      = auth()->user();
        $addresses = $user->addresses;
        $coupon    = null;

        if (session('applied_coupon')) {
            $coupon = Coupon::where('code', session('applied_coupon'))->first();
        }

        $subtotal   = $cart->subtotal;
        $discount   = $coupon ? $coupon->calculateDiscount($subtotal) : 0;
        $serviceFee = 0; // Digital service — no shipping fee
        $total      = $subtotal - $discount + $serviceFee;

        return view('customer.checkout', compact('cart', 'addresses', 'coupon', 'subtotal', 'discount', 'serviceFee', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'        => 'required|string|max:255',
            'client_email'     => 'required|email|max:255',
            'phone'            => 'required|string|max:20',
            'country'          => 'required|string|max:100',
            'province'         => 'required|string|max:100',
            'city'             => 'required|string|max:100',
            'address'          => 'required|string',
            'organisation'     => 'nullable|string|max:255',
            'existing_domain'  => 'nullable|string|max:255',
            'is_first_website' => 'nullable|boolean',
            'website_type'     => 'nullable|string|max:100',
            'preferred_colors' => 'nullable|string|max:255',
            'social_media_links' => 'nullable|string|max:1000',
            'payment_method'   => 'required|in:bank_transfer,cash_on_delivery',
            'notes'            => 'nullable|string|max:1000',
            'attachment_file'  => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,zip|max:25600',
        ]);

        $cart = Cart::where('user_id', auth()->id())
            ->with(['items.product'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return back()->with('error', "Insufficient license slots for: {$item->product->name}");
            }
        }

        $coupon = null;
        if (session('applied_coupon')) {
            $coupon = Coupon::where('code', session('applied_coupon'))->first();
        }

        $subtotal   = $cart->subtotal;
        $discount   = $coupon ? $coupon->calculateDiscount($subtotal) : 0;
        $serviceFee = 0;
        $total      = $subtotal - $discount + $serviceFee;

        // Calculate development due date (max duration across all cart items)
        $maxDays = $cart->items->reduce(function ($carry, $item) {
            return max($carry, $item->product->development_days ?? 21);
        }, 0);
        $developmentDueDate = now()->addDays($maxDays)->toDateString();

        // Store uploaded file temporarily before transaction
        $uploadedFile     = $request->file('attachment_file');
        $originalName     = $uploadedFile->getClientOriginalName();
        $safeBasename     = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        $ext              = $uploadedFile->getClientOriginalExtension();
        $tempPath         = $uploadedFile->getRealPath();
        $fileContents     = file_get_contents($tempPath);

        $newOrder = null;

        DB::transaction(function () use (
            $request, $cart, $coupon, $subtotal, $discount, $serviceFee, $total,
            $developmentDueDate, $originalName, $safeBasename, $ext, $fileContents, &$newOrder
        ) {
            $clientInfo = [
                'full_name'   => $request->full_name,
                'phone'       => $request->phone,
                'country'     => $request->country,
                'province'    => $request->province,
                'city'        => $request->city,
                'address'     => $request->address,
                'postal_code' => $request->postal_code,
            ];

            $order = Order::create([
                'user_id'              => auth()->id(),
                'order_number'         => Order::generateOrderNumber(),
                'shipping_address'     => $clientInfo,
                'subtotal'             => $subtotal,
                'shipping'             => $serviceFee,
                'discount'             => $discount,
                'tax'                  => 0,
                'total'                => $total,
                'payment_method'       => $request->payment_method,
                'payment_status'       => 'pending',
                'order_status'         => 'pending',
                'notes'                => $request->notes,
                'development_due_date' => $developmentDueDate,
                'client_email'         => $request->client_email,
                'organisation'         => $request->organisation,
                'existing_domain'      => $request->existing_domain,
                'is_first_website'     => $request->boolean('is_first_website'),
                'website_type'         => $request->website_type,
                'preferred_colors'     => $request->preferred_colors,
                'social_media_links'   => $request->social_media_links,
            ]);

            // Store attachment
            $filename   = $safeBasename . '-' . $order->id . '.' . $ext;
            $storagePath = 'order-attachments/' . $order->id . '/' . $filename;
            Storage::disk('public')->makeDirectory('order-attachments/' . $order->id);
            Storage::disk('public')->put($storagePath, $fileContents);

            $order->update([
                'attachment_path'          => $storagePath,
                'attachment_original_name' => $originalName,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item->product_id,
                    'product_name'=> $item->product->name,
                    'product_sku' => $item->product->sku,
                    'quantity'    => $item->quantity,
                    'price'       => $item->price,
                    'features'    => $item->features,
                    'total'       => $item->total,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            if ($coupon) {
                $coupon->increment('used_count');
                session()->forget('applied_coupon');
            }

            $cart->allItems()->delete();

            $newOrder = $order;
            session(['last_order_id' => $order->id]);
        });

        if ($newOrder) {
            try {
                $newOrder->load('items.product');

                $confirmEnabled = Setting::get('order_confirmation_enabled', '1') === '1';
                $alertEnabled   = Setting::get('order_alert_enabled', '1') === '1';
                $alertEmail     = Setting::get('order_alert_email', 'ttsl.support@gmail.com');

                if ($confirmEnabled) {
                    Mail::to($newOrder->client_email)->send(new OrderConfirmation($newOrder));
                }
                if ($alertEnabled && $alertEmail) {
                    Mail::to($alertEmail)->send(new NewOrderAlert($newOrder));
                }
            } catch (\Exception $e) {
                Log::error('Order email notification failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        $orderId = session('last_order_id');
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with('items')->findOrFail($orderId);
        return view('customer.order-success', compact('order'));
    }
}
