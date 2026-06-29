<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.features.index', compact('features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'description'=> 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Feature::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'price'       => $request->price,
            'status'      => $request->boolean('status', true),
            'sort_order'  => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Feature created.');
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'description'=> 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $feature->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'status'      => $request->boolean('status'),
            'sort_order'  => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Feature updated.');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return back()->with('success', 'Feature deleted.');
    }
}
