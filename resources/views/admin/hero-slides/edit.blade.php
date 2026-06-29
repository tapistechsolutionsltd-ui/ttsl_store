@extends('layouts.admin')
@section('title', 'Edit Hero Slide')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.hero-slides.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-brand">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Hero Slides
    </a>
</div>

<form method="POST" action="{{ route('admin.hero-slides.update', $heroSlide) }}" enctype="multipart/form-data"
      x-data="heroSlideForm()" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf
    @method('PUT')

    {{-- Left column --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Text Content --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Slide Text
            </h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Badge Text</label>
                        <input type="text" name="badge_text" value="{{ old('badge_text', $heroSlide->badge_text) }}"
                               class="input-field" placeholder="e.g. Papua New Guinea's #1 ICT Store">
                    </div>
                    <div>
                        <label class="form-label">Badge Colour</label>
                        <div class="flex gap-2 items-center">
                            <input type="color" name="badge_color"
                                   value="{{ old('badge_color', $heroSlide->badge_color) }}"
                                   class="w-10 h-10 rounded cursor-pointer border border-gray-300 p-0.5">
                            <span class="text-sm text-gray-500">{{ old('badge_color', $heroSlide->badge_color) }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="form-label">Slide Title</label>
                    <input type="text" name="title" value="{{ old('title', $heroSlide->title) }}"
                           class="input-field text-lg font-medium" placeholder="Slide headline">
                </div>
                <div>
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $heroSlide->subtitle) }}"
                           class="input-field" placeholder="Supporting tagline">
                </div>
                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="2" class="input-field resize-none"
                              placeholder="Paragraph text below subtitle">{{ old('description', $heroSlide->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                </svg>
                Call-to-Action Buttons
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Primary Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $heroSlide->button_text) }}"
                           class="input-field" placeholder="Shop Now">
                </div>
                <div>
                    <label class="form-label">Primary Button URL</label>
                    <input type="text" name="button_url" value="{{ old('button_url', $heroSlide->button_url) }}"
                           class="input-field" placeholder="/shop">
                </div>
                <div>
                    <label class="form-label">Secondary Button Text</label>
                    <input type="text" name="secondary_button_text"
                           value="{{ old('secondary_button_text', $heroSlide->secondary_button_text) }}"
                           class="input-field" placeholder="Contact Us">
                </div>
                <div>
                    <label class="form-label">Secondary Button URL</label>
                    <input type="text" name="secondary_button_url"
                           value="{{ old('secondary_button_url', $heroSlide->secondary_button_url) }}"
                           class="input-field" placeholder="/contact">
                </div>
            </div>
        </div>

        {{-- Image --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-800 mb-1 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Background Image / Video
            </h3>
            <p class="text-xs text-gray-400 mb-4">Recommended: 1920×600px or wider. Supports JPG, PNG, WebP, GIF or MP4 (max 20 MB). MP4 videos autoplay, loop and are muted.</p>

            @if($heroSlide->image_path)
                <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-500 mb-2 font-medium">Current {{ $heroSlide->is_video ? 'video' : 'image' }}:</p>
                    @if($heroSlide->is_video)
                        <video src="{{ $heroSlide->image_url }}" class="max-h-32 rounded-lg" autoplay loop muted playsinline></video>
                    @else
                        <img src="{{ $heroSlide->image_url }}" alt="Current" class="max-h-32 rounded-lg object-cover">
                    @endif
                    <div class="mt-3 flex items-center gap-2">
                        <input type="hidden" name="remove_image" value="0">
                        <input type="checkbox" name="remove_image" id="remove_image" value="1"
                               class="w-4 h-4 accent-red-500 rounded">
                        <label for="remove_image" class="text-sm text-red-600">Remove current {{ $heroSlide->is_video ? 'video' : 'image' }} (use background colour)</label>
                    </div>
                </div>
            @endif

            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-brand transition-colors cursor-pointer"
                 @click="$refs.imageInput.click()">
                <template x-if="!imagePreview">
                    <div>
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm text-gray-500">Click to upload a new image or video</p>
                        <p class="text-xs text-gray-400 mt-1">JPEG, PNG, WebP, GIF, MP4 — max 20 MB</p>
                    </div>
                </template>
                <template x-if="imagePreview && !isVideoPreview">
                    <div class="relative">
                        <img :src="imagePreview" class="max-h-40 mx-auto rounded-lg object-cover">
                        <button type="button" @click.stop="clearPreview()"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </template>
                <template x-if="imagePreview && isVideoPreview">
                    <div class="relative">
                        <video :src="imagePreview" class="max-h-40 mx-auto rounded-lg" autoplay loop muted playsinline></video>
                        <button type="button" @click.stop="clearPreview()"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
            <input type="file" name="image" x-ref="imageInput" accept="image/*,video/mp4" class="hidden"
                   @change="previewImage($event)">
        </div>
    </div>

    {{-- Right column --}}
    <div class="space-y-5">

        {{-- Appearance --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Appearance
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="form-label">Background Colour</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" name="bg_color"
                               value="{{ old('bg_color', $heroSlide->bg_color) }}"
                               class="w-10 h-10 rounded cursor-pointer border border-gray-300 p-0.5">
                        <span class="text-sm text-gray-500">{{ old('bg_color', $heroSlide->bg_color) }}</span>
                    </div>
                </div>
                <div>
                    <label class="form-label">Text Colour</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" name="text_color"
                               value="{{ old('text_color', $heroSlide->text_color) }}"
                               class="w-10 h-10 rounded cursor-pointer border border-gray-300 p-0.5">
                        <span class="text-sm text-gray-500">{{ old('text_color', $heroSlide->text_color) }}</span>
                    </div>
                </div>
                <div>
                    <label class="form-label">Image Overlay Opacity</label>
                    <div class="flex items-center gap-3">
                        <input type="range" name="overlay_opacity" min="0" max="100"
                               value="{{ old('overlay_opacity', $heroSlide->overlay_opacity) }}"
                               x-model="overlayOpacity" class="flex-1 accent-brand">
                        <span class="text-sm font-medium text-gray-700 w-10 text-right" x-text="overlayOpacity + '%'"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Publishing --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Publishing
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order"
                           value="{{ old('sort_order', $heroSlide->sort_order) }}"
                           min="0" class="input-field">
                </div>
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $heroSlide->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 accent-brand rounded">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Active (visible on store)</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Save Changes
        </button>

        {{-- type="button" so it never submits the update form --}}
        <button type="button"
                onclick="askConfirm('Are you sure you want to permanently delete this slide? This action cannot be undone.', () => document.getElementById('delete-slide-form').submit(), 'Delete Slide')"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Delete Slide
        </button>
    </div>

</form>

{{-- Delete form lives outside the update form — nested forms cause _method=DELETE to bleed into the update submission --}}
<form id="delete-slide-form" method="POST" action="{{ route('admin.hero-slides.destroy', $heroSlide) }}" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function heroSlideForm() {
    return {
        imagePreview: null,
        isVideoPreview: false,
        overlayOpacity: {{ old('overlay_opacity', $heroSlide->overlay_opacity) }},
        previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.isVideoPreview = file.type.startsWith('video/');
            const reader = new FileReader();
            reader.onload = e => this.imagePreview = e.target.result;
            reader.readAsDataURL(file);
        },
        clearPreview() {
            this.imagePreview = null;
            this.isVideoPreview = false;
            this.$refs.imageInput.value = '';
        }
    }
}
</script>
@endpush

@endsection
