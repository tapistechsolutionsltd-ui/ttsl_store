<?php

namespace App\Http\Controllers\Admin\Cpp;

use App\Http\Controllers\Controller;
use App\Models\CppPromotion;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = CppPromotion::withCount('clients')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $promotions = $query->paginate(15)->withQueryString();

        return view('admin.cpp.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.cpp.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $validated['slug'] = Str::slug($request->title) . '-' . Str::random(4);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('cpp-banners', 'public');
        }

        $validated['instructions'] = $this->parseInstructions($request->input('instructions'));

        $promotion = CppPromotion::create($validated);

        $this->syncEligibleProducts($promotion, $request->input('product_ids', []));

        return redirect()->route('admin.cpp.promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function edit(CppPromotion $promotion)
    {
        $products = Product::orderBy('name')->get();
        return view('admin.cpp.promotions.edit', compact('promotion', 'products'));
    }

    public function update(Request $request, CppPromotion $promotion)
    {
        $validated = $this->validated($request);

        if ($request->hasFile('banner_image')) {
            if ($promotion->banner_image) {
                Storage::disk('public')->delete($promotion->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('cpp-banners', 'public');
        }

        $validated['instructions'] = $this->parseInstructions($request->input('instructions'));

        $promotion->update($validated);

        $this->syncEligibleProducts($promotion, $request->input('product_ids', []));

        return redirect()->route('admin.cpp.promotions.index')->with('success', 'Promotion updated successfully.');
    }

    private function syncEligibleProducts(CppPromotion $promotion, array $productIds): void
    {
        Product::where('cpp_promotion_id', $promotion->id)
            ->whereNotIn('id', $productIds)
            ->update(['cpp_promotion_id' => null, 'cpp_enabled' => false]);

        Product::whereIn('id', $productIds)
            ->update(['cpp_promotion_id' => $promotion->id, 'cpp_enabled' => true]);
    }

    public function destroy(CppPromotion $promotion)
    {
        if ($promotion->banner_image) {
            Storage::disk('public')->delete($promotion->banner_image);
        }
        $promotion->delete();

        return back()->with('success', 'Promotion deleted.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'subtitle'     => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:4096',
            'start_date'   => 'nullable|date',
            'expiry_date'  => 'nullable|date',
            'max_clients'  => 'nullable|integer|min:1',
            'status'       => 'required|in:draft,published,expired,closed',
            'code_prefix'  => 'nullable|string|max:20',
            'enable_portal'        => 'nullable|boolean',
            'allow_search'         => 'nullable|boolean',
            'show_client_counter'  => 'nullable|boolean',
            'show_remaining_slots' => 'nullable|boolean',
            'show_timeline'        => 'nullable|boolean',
            'auto_close'           => 'nullable|boolean',
            'auto_expire'          => 'nullable|boolean',
            'display_on_homepage'  => 'nullable|boolean',
        ]);

        foreach (['enable_portal', 'allow_search', 'show_client_counter', 'show_remaining_slots', 'show_timeline', 'auto_close', 'auto_expire', 'display_on_homepage'] as $flag) {
            $validated[$flag] = $request->boolean($flag);
        }

        return $validated;
    }

    private function parseInstructions(?string $raw): array
    {
        if (!$raw) {
            return [];
        }
        return collect(explode("\n", trim($raw)))
            ->map(fn($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
