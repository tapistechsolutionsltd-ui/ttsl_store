<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CppPromotion;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand'])->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products   = $query->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        $brands     = Brand::where('status', true)->get();
        $promotions = CppPromotion::orderBy('title')->get();
        return view('admin.products.create', compact('categories', 'brands', 'promotions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'brand_id'     => 'nullable|exists:brands,id',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'sale_price'   => 'nullable|numeric',
            'stock'        => 'required|integer|min:0',
            'status'       => 'required|in:active,inactive,draft',
            'development_duration'=> 'nullable|string|max:50',
            'images.*'            => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:4096',
            'preview_zip'         => 'nullable|file|mimes:zip|max:51200',
            'cpp_promotion_id'    => 'nullable|exists:cpp_promotions,id',
            'cpp_badge_text'      => 'nullable|string|max:100',
            'cpp_priority'        => 'nullable|integer|min:0',
            'cpp_description'     => 'nullable|string|max:1000',
        ]);

        $data = $request->only(['name', 'category_id', 'brand_id', 'description', 'price', 'sale_price', 'stock', 'status', 'development_duration']);
        $data['slug']     = Str::slug($request->name) . '-' . Str::random(4);
        $data['sku']      = 'NGS-' . strtoupper(Str::random(8));
        $data['featured'] = $request->boolean('featured');
        $data['cpp_enabled']       = $request->boolean('cpp_enabled');
        $data['cpp_promotion_id']  = $request->cpp_promotion_id;
        $data['cpp_badge_text']    = $request->cpp_badge_text;
        $data['cpp_priority']      = $request->cpp_priority ?? 0;
        $data['cpp_description']   = $request->cpp_description;

        if ($request->filled('specifications')) {
            $specs = [];
            foreach (explode("\n", trim($request->specifications)) as $line) {
                $line = trim($line);
                if ($line && str_contains($line, ':')) {
                    [$key, $val] = explode(':', $line, 2);
                    $specs[trim($key)] = trim($val);
                }
            }
            $data['specifications'] = $specs;
        }

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            Storage::disk('public')->makeDirectory('products');

            foreach ($request->file('images') as $i => $image) {
                $filename = 'products/' . Str::uuid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put($filename, file_get_contents($image->getRealPath()));

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $filename,
                    'is_primary' => $i === 0,
                    'sort_order' => $i,
                ]);
            }
        }

        if ($request->hasFile('preview_zip')) {
            [$path, $entry] = $this->extractPreviewZip($request->file('preview_zip'), $product->id);
            $product->update(['preview_path' => $path, 'preview_entry' => $entry]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product "' . $product->name . '" created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::where('status', true)->get();
        $brands     = Brand::where('status', true)->get();
        $promotions = CppPromotion::orderBy('title')->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'promotions'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'brand_id'     => 'nullable|exists:brands,id',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'sale_price'   => 'nullable|numeric',
            'stock'        => 'required|integer|min:0',
            'status'       => 'required|in:active,inactive,draft',
            'development_duration'=> 'nullable|string|max:50',
            'images.*'            => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:4096',
            'preview_zip'         => 'nullable|file|mimes:zip|max:51200',
            'cpp_promotion_id'    => 'nullable|exists:cpp_promotions,id',
            'cpp_badge_text'      => 'nullable|string|max:100',
            'cpp_priority'        => 'nullable|integer|min:0',
            'cpp_description'     => 'nullable|string|max:1000',
        ]);

        $data = $request->only(['name', 'category_id', 'brand_id', 'description', 'price', 'sale_price', 'stock', 'status', 'development_duration']);
        $data['featured'] = $request->boolean('featured');
        $data['cpp_enabled']       = $request->boolean('cpp_enabled');
        $data['cpp_promotion_id']  = $request->cpp_promotion_id;
        $data['cpp_badge_text']    = $request->cpp_badge_text;
        $data['cpp_priority']      = $request->cpp_priority ?? 0;
        $data['cpp_description']   = $request->cpp_description;

        if ($request->filled('specifications')) {
            $specs = [];
            foreach (explode("\n", trim($request->specifications)) as $line) {
                $line = trim($line);
                if ($line && str_contains($line, ':')) {
                    [$key, $val] = explode(':', $line, 2);
                    $specs[trim($key)] = trim($val);
                }
            }
            $data['specifications'] = $specs;
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            Storage::disk('public')->makeDirectory('products');

            foreach ($request->file('images') as $i => $image) {
                $filename = 'products/' . Str::uuid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put($filename, file_get_contents($image->getRealPath()));

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $filename,
                    'is_primary' => $product->images()->count() === 0 && $i === 0,
                    'sort_order' => $product->images()->count() + $i,
                ]);
            }
        }

        if ($request->hasFile('preview_zip')) {
            [$path, $entry] = $this->extractPreviewZip($request->file('preview_zip'), $product->id);
            $product->update(['preview_path' => $path, 'preview_entry' => $entry]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
        }
        if ($product->preview_path) {
            Storage::disk('public')->deleteDirectory($product->preview_path);
        }
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Image removed.');
    }

    public function deletePreview(Product $product)
    {
        if ($product->preview_path) {
            Storage::disk('public')->deleteDirectory($product->preview_path);
            $product->update(['preview_path' => null, 'preview_entry' => null]);
        }
        return back()->with('success', 'Website preview removed.');
    }

    private function extractPreviewZip(UploadedFile $zipFile, int $productId): array
    {
        $dir     = "previews/{$productId}";
        $destBase = storage_path("app/public/{$dir}");

        // Remove old preview if exists
        Storage::disk('public')->deleteDirectory($dir);

        $zip = new ZipArchive();
        if ($zip->open($zipFile->getRealPath()) !== true) {
            throw new \RuntimeException('Could not open ZIP file.');
        }

        $allowedExtensions = [
            'html', 'htm', 'css', 'js', 'mjs',
            'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico',
            'woff', 'woff2', 'ttf', 'eot', 'otf',
            'json', 'xml', 'txt', 'map',
        ];

        // Collect file list to detect single-folder nesting
        $names = [];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $names[] = $zip->getNameIndex($i);
        }

        // If every file starts with the same folder prefix, strip it
        $prefix       = '';
        $firstSegment = explode('/', $names[0] ?? '')[0];
        if ($firstSegment && !str_contains($names[0], '.')) {
            $candidate = $firstSegment . '/';
            if (collect($names)->every(fn($n) => str_starts_with($n, $candidate))) {
                $prefix = $candidate;
            }
        }

        if (!is_dir($destBase)) {
            mkdir($destBase, 0755, true);
        }

        $htmlFiles = [];

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name     = $zip->getNameIndex($i);
            $relative = $prefix ? substr($name, strlen($prefix)) : $name;

            if (!$relative || str_ends_with($relative, '/')) continue;
            if (str_contains($relative, '..') || str_starts_with($relative, '/')) continue;

            $ext = strtolower(pathinfo($relative, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExtensions, true)) continue;

            $dest    = $destBase . '/' . $relative;
            $destDir = dirname($dest);
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }

            $content = $zip->getFromIndex($i);
            if ($content !== false) {
                file_put_contents($dest, $content);
            }

            if (in_array($ext, ['html', 'htm'], true) && !str_contains($relative, '/')) {
                $htmlFiles[] = $relative;
            }
        }

        $zip->close();

        // Determine entry file: prefer index.html, otherwise first html found
        $entry = 'index.html';
        if (!file_exists($destBase . '/index.html')) {
            $entry = collect($htmlFiles)->first() ?? 'index.html';
        }

        return [$dir, $entry];
    }
}
