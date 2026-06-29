<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'nullable|image|max:1024',
            'website_url' => 'nullable|url|max:255',
        ]);

        $data           = ['name' => $request->name, 'slug' => Str::slug($request->name)];
        $data['status']      = $request->boolean('status', true);
        $data['website_url'] = $request->website_url;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        Brand::create($data);
        return back()->with('success', 'DevTool created.');
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'website_url' => 'nullable|url|max:255',
        ]);

        $data                = ['name' => $request->name, 'website_url' => $request->website_url];
        $data['status'] = $request->boolean('status');

        if ($request->hasFile('logo')) {
            if ($brand->logo) Storage::disk('public')->delete($brand->logo);
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $brand->update($data);
        return back()->with('success', 'DevTool updated.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return back()->with('error', 'Cannot delete a DevTool that has products.');
        }
        $brand->delete();
        return back()->with('success', 'DevTool deleted.');
    }
}
