<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Feature;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart()
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function index()
    {
        $cart = $this->getCart();
        $cart->load(['items.product.images', 'savedItems.product.images']);
        return view('customer.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:100',
            'features'   => 'nullable|array',
            'features.*' => 'integer|exists:features,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->status !== 'active' || $product->stock < 1) {
            return back()->with('error', 'Product is not available.');
        }

        if ($request->quantity > $product->stock) {
            return back()->with('error', "Only {$product->stock} items available.");
        }

        $selectedFeatures = Feature::active()->whereIn('id', $request->input('features', []))->get();
        $featuresSnapshot = $selectedFeatures->map(fn ($f) => [
            'id' => $f->id, 'name' => $f->name, 'price' => (float) $f->price,
        ])->values()->all();
        $featuresTotal = $selectedFeatures->sum('price');
        $unitPrice = $product->current_price + $featuresTotal;

        $cart = $this->getCart();
        // One line per product per cart — re-adding with a different feature selection
        // updates that line's add-ons/price instead of creating a duplicate.
        $cartItem = $cart->allItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', "Cannot add more. Only {$product->stock} items in stock.");
            }
            $cartItem->update([
                'quantity'        => $newQty,
                'price'           => $unitPrice,
                'features'        => $featuresSnapshot,
                'saved_for_later' => false,
            ]);
        } else {
            $cart->allItems()->create([
                'product_id'      => $product->id,
                'quantity'        => $request->quantity,
                'price'           => $unitPrice,
                'features'        => $featuresSnapshot,
                'saved_for_later' => false,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        abort_unless((int) $cartItem->cart->user_id === (int) auth()->id(), 403);
        $request->validate(['quantity' => 'required|integer|min:1|max:100']);

        if ($request->quantity > $cartItem->product->stock) {
            return back()->with('error', "Only {$cartItem->product->stock} items available.");
        }

        $cartItem->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        abort_unless((int) $cartItem->cart->user_id === (int) auth()->id(), 403);
        $cartItem->delete();
        return back()->with('success', 'Item removed from cart.');
    }

    public function saveForLater(CartItem $cartItem)
    {
        abort_unless((int) $cartItem->cart->user_id === (int) auth()->id(), 403);
        $cartItem->update(['saved_for_later' => true]);
        return back()->with('success', 'Item saved for later.');
    }

    public function moveToCart(CartItem $cartItem)
    {
        abort_unless((int) $cartItem->cart->user_id === (int) auth()->id(), 403);
        $cartItem->update(['saved_for_later' => false]);
        return back()->with('success', 'Item moved to cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon' => 'required|string']);

        $coupon = Coupon::where('code', strtoupper($request->coupon))->first();
        $cart   = $this->getCart();

        if (!$coupon || !$coupon->isValid($cart->subtotal)) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        session(['applied_coupon' => $coupon->code]);
        return back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        return back()->with('success', 'Coupon removed.');
    }

    public function count()
    {
        if (!auth()->check()) return response()->json(['count' => 0]);
        $cart = Cart::where('user_id', auth()->id())->first();
        $count = $cart ? $cart->item_count : 0;
        return response()->json(['count' => $count]);
    }
}