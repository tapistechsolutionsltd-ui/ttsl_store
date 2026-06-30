<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                  => 'nullable|string|max:255',
            'subtitle'               => 'nullable|string|max:255',
            'description'            => 'nullable|string|max:1000',
            'badge_text'             => 'nullable|string|max:100',
            'badge_color'            => 'nullable|string|max:30',
            'button_text'            => 'nullable|string|max:100',
            'button_url'             => 'nullable|string|max:255',
            'secondary_button_text'  => 'nullable|string|max:100',
            'secondary_button_url'   => 'nullable|string|max:255',
            'image'                  => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,mp4|max:20480',
            'bg_color'               => 'nullable|string|max:30',
            'text_color'             => 'nullable|string|max:30',
            'overlay_opacity'        => 'nullable|integer|min:0|max:100',
            'sort_order'             => 'nullable|integer|min:0',
            'is_active'              => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? HeroSlide::max('sort_order') + 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return back()->withInput()->with('error',
                    'Upload failed: ' . $file->getErrorMessage() . ' Check the file size against the server upload limit.');
            }
            $validated['image_path'] = $file->store('hero-slides', 'public');
        }

        HeroSlide::create($validated);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide created successfully.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'title'                  => 'nullable|string|max:255',
            'subtitle'               => 'nullable|string|max:255',
            'description'            => 'nullable|string|max:1000',
            'badge_text'             => 'nullable|string|max:100',
            'badge_color'            => 'nullable|string|max:30',
            'button_text'            => 'nullable|string|max:100',
            'button_url'             => 'nullable|string|max:255',
            'secondary_button_text'  => 'nullable|string|max:100',
            'secondary_button_url'   => 'nullable|string|max:255',
            'image'                  => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,mp4|max:20480',
            'remove_image'           => 'nullable|boolean',
            'bg_color'               => 'nullable|string|max:30',
            'text_color'             => 'nullable|string|max:30',
            'overlay_opacity'        => 'nullable|integer|min:0|max:100',
            'sort_order'             => 'nullable|integer|min:0',
            'is_active'              => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->boolean('remove_image') && $heroSlide->image_path) {
            Storage::disk('public')->delete($heroSlide->image_path);
            $validated['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return back()->withInput()->with('error',
                    'Upload failed: ' . $file->getErrorMessage() . ' Check the file size against the server upload limit.');
            }
            if ($heroSlide->image_path) {
                Storage::disk('public')->delete($heroSlide->image_path);
            }
            $validated['image_path'] = $file->store('hero-slides', 'public');
        }

        $heroSlide->update($validated);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image_path) {
            Storage::disk('public')->delete($heroSlide->image_path);
        }
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide deleted.');
    }

    public function toggleActive(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => !$heroSlide->is_active]);
        return back()->with('success', 'Slide status updated.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $position => $id) {
            HeroSlide::where('id', $id)->update(['sort_order' => $position]);
        }
        return response()->json(['success' => true]);
    }
}
