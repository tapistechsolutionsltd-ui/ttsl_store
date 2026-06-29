<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user         = auth()->user();
        $recentOrders = $user->orders()->latest()->take(5)->get();
        $orderCount   = $user->orders()->count();
        $wishlistCount = $user->wishlists()->count();

        return view('customer.dashboard', compact('user', 'recentOrders', 'orderCount', 'wishlistCount'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product');
        return view('customer.order-detail', compact('order'));
    }

    public function profile()
    {
        return view('customer.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($request->only('name', 'phone'));
        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|min:8|confirmed',
        ]);

        auth()->user()->update(['password' => $request->password]);
        return back()->with('success', 'Password updated successfully.');
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses;
        return view('customer.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'full_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'province'   => 'required|string|max:100',
            'city'       => 'required|string|max:100',
            'address'    => 'required|string',
            'is_default' => 'boolean',
        ]);

        if ($request->boolean('is_default')) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create($request->validated() + ['country' => 'Papua New Guinea']);
        return back()->with('success', 'Address added.');
    }

    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);
        $address->delete();
        return back()->with('success', 'Address removed.');
    }

    public function wishlist()
    {
        $wishlists = auth()->user()->wishlists()->with('product.images')->paginate(12);
        return view('customer.wishlist', compact('wishlists'));
    }

    public function toggleWishlist(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $user     = auth()->user();
        $existing = $user->wishlists()->where('product_id', $request->product_id)->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            $user->wishlists()->create(['product_id' => $request->product_id]);
            $status = 'added';
        }

        $count = $user->wishlists()->count();

        return response()->json(['status' => $status, 'count' => $count]);
    }
}