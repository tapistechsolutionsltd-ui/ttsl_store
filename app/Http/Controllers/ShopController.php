<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['images', 'category', 'brand'])->active();

        // Search
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%')
                  ->orWhere('sku', 'like', '%' . $request->q . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->whereHas('brand', fn($q) => $q->where('slug', $request->brand));
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // In stock filter
        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        // Sort
        match ($request->sort ?? 'latest') {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc'   => $query->orderBy('name'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::where('status', true)->withCount('activeProducts')->orderBy('sort_order')->get();
        $brands     = Brand::where('status', true)->get();

        return view('pages.shop', compact('products', 'categories', 'brands'));
    }

    public function category(Category $category, Request $request)
    {
        $query = Product::with(['images', 'brand'])
            ->active()
            ->where('category_id', $category->id);

        if ($request->filled('brand')) {
            $query->whereHas('brand', fn($q) => $q->where('slug', $request->brand));
        }

        $sortBy = $request->sort ?? 'latest';
        match ($sortBy) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $brands     = Brand::where('status', true)->get();

        return view('pages.category', compact('category', 'products', 'categories', 'brands'));
    }

    public function product(Product $product)
    {
        if ($product->status !== 'active') {
            abort(404);
        }

        $product->load(['images', 'category', 'brand']);

        $relatedProducts = Product::with('images')
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $isWishlisted = false;
        if (auth()->check()) {
            $isWishlisted = auth()->user()->wishlists()
                ->where('product_id', $product->id)->exists();
        }

        $features = Feature::active()->orderBy('sort_order')->orderBy('name')->get();

        // Pre-check whichever add-ons the user already has selected for this product in their cart
        $selectedFeatureIds = [];
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            $existingCartItem = $cart
                ? $cart->items()->where('product_id', $product->id)->latest('updated_at')->first()
                : null;
            if ($existingCartItem) {
                $selectedFeatureIds = collect($existingCartItem->features ?? [])->pluck('id')->all();
            }
        }

        return view('pages.product', compact('product', 'relatedProducts', 'isWishlisted', 'features', 'selectedFeatureIds'));
    }
}
