<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', function (Request $request) {
    return Product::with(['images', 'category', 'brand'])
        ->active()
        ->when($request->category, fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $request->category)))
        ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
        ->paginate(20);
});

Route::get('/categories', function () {
    return Category::where('status', true)->withCount('activeProducts')->get();
});
