@extends('layouts.admin')
@section('title', 'Add Hero Slide')

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

<form method="POST" action="{{ route('admin.hero-slides.store') }}" enctype="multipart/form-data"
      x-data="heroSlideForm()" @submit.prevent="submitForm($event)" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    {{-- Left column: main settings --}}
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
                        <label class="form-label">Badge Text <span class="text-gray-400 font-normal text-xs">(small label above title)</span></label>
                        <input type="text" name="badge_text" value="{{ old('badge_text') }}"
                               class="input-field" placeholder="e.g. Papua New Guinea's #1 ICT Store">
                    </div>
                    <div>
                        <label class="form-label">Badge Colour</label>
                        <div class="flex gap-2 items-center">
                            <input type="color" name="badge_color" value="{{ old('badge_color', '#f59e0b') }}"
                                   class="w-10 h-10 rounded cursor-pointer border border-gray-300 p-0.5">
                            <input type="text" x-model="badgeColor" name="badge_color_hex"
                                   class="input-field flex-1" placeholder="#f59e0b" readonly>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="form-label">Slide Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="input-field text-lg font-medium" placeholder="e.g. Technology & Industrial Solutions For PNG">
                </div>
                <div>
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                           class="input-field" placeholder="e.g. Premium ICT Equipment, Hardware & Industrial Supplies">
                </div>
                <div>
                    <label class="form-label">Description <span class="text-gray-400 font-normal text-xs">(optional paragraph text)</span></label>
                    <textarea name="description" rows="2" class="input-field resize-none"
                              placeholder="Computers, laptops, office supplies, heavy equipment, and more — all priced in Papua New Guinea Kina.">{{ old('description') }}</textarea>
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
                    <input type="text" name="button_text" value="{{ old('button_text') }}"
                           class="input-field" placeholder="Shop Now">
                </div>
                <div>
                    <label class="form-label">Primary Button URL</label>
                    <input type="text" name="button_url" value="{{ old('button_url', '/shop') }}"
                           class="input-field" placeholder="/shop">
                </div>
                <div>
                    <label class="form-label">Secondary Button Text</label>
                    <input type="text" name="secondary_button_text" value="{{ old('secondary_button_text') }}"
                           class="input-field" placeholder="Contact Us">
                </div>
                <div>
                    <label class="form-label">Secondary Button URL</label>
                    <input type="text" name="secondary_button_url" value="{{ old('secondary_button_url', '/contact') }}"
                           class="input-field" placeholder="/contact">
                </div>
            </div>
        </div>

        {{-- Image Upload --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-800 mb-1 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Background Image / Video
            </h3>
            <p class="text-xs text-gray-400 mb-4">Recommended: 1920×600px or wider. Supports JPG, PNG, WebP, GIF or MP4 (max 50 MB). MP4 videos autoplay, loop and are muted. Leave empty to use background colour instead.</p>

            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-brand transition-colors cursor-pointer"
                 @click="$refs.imageInput.click()">
                <template x-if="!imagePreview">
                    <div>
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm text-gray-500">Click to upload hero image or video</p>
                        <p class="text-xs text-gray-400 mt-1">JPEG, PNG, WebP, GIF, MP4 — max 50 MB</p>
                    </div>
                </template>
                <template x-if="imagePreview && !isVideoPreview">
                    <div class="relative">
                        <img :src="imagePreview" class="max-h-48 mx-auto rounded-lg object-cover">
                        <button type="button" @click.stop="clearPreview()"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </template>
                <template x-if="imagePreview && isVideoPreview">
                    <div class="relative">
                        <video :src="imagePreview" class="max-h-48 mx-auto rounded-lg" autoplay loop muted playsinline></video>
                        <button type="button" @click.stop="clearPreview()"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
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

    {{-- Right column: appearance settings --}}
    <div class="space-y-5">

        {{-- Background & Colours --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Appearance
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="form-label">Background Colour <span class="text-gray-400 font-normal text-xs">(used if no image)</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" name="bg_color" value="{{ old('bg_color', '#1e3a5f') }}"
                               class="w-10 h-10 rounded cursor-pointer border border-gray-300 p-0.5">
                        <span class="text-sm text-gray-500">{{ old('bg_color', '#1e3a5f') }}</span>
                    </div>
                </div>
                <div>
                    <label class="form-label">Text Colour</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" name="text_color" value="{{ old('text_color', '#ffffff') }}"
                               class="w-10 h-10 rounded cursor-pointer border border-gray-300 p-0.5">
                        <span class="text-sm text-gray-500">{{ old('text_color', '#ffffff') }}</span>
                    </div>
                </div>
                <div>
                    <label class="form-label">Image Overlay Opacity
                        <span class="text-gray-400 font-normal text-xs">(0 = none, 100 = black)</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="range" name="overlay_opacity" min="0" max="100"
                               value="{{ old('overlay_opacity', 40) }}" x-model="overlayOpacity"
                               class="flex-1 accent-brand">
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
                    <label class="form-label">Sort Order <span class="text-gray-400 font-normal text-xs">(lower = first)</span></label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                           min="0" class="input-field">
                </div>
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                           class="w-4 h-4 accent-brand rounded">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Active (visible on store)</label>
                </div>
            </div>
        </div>

        <template x-if="uploadError">
            <div class="alert-error text-sm" x-text="uploadError"></div>
        </template>

        <template x-if="uploading">
            <div class="space-y-1">
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-brand transition-all duration-150" :style="`width: ${uploadProgress}%`"></div>
                </div>
                <p class="text-xs text-gray-500 text-center" x-text="uploadProgress < 100 ? `Uploading… ${uploadProgress}%` : 'Finishing up…'"></p>
            </div>
        </template>

        <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2" :disabled="uploading">
            <svg x-show="!uploading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <svg x-show="uploading" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span x-text="uploading ? 'Saving…' : 'Create Slide'"></span>
        </button>
    </div>

</form>

@push('scripts')
<script>
function heroSlideForm() {
    return {
        imagePreview: null,
        isVideoPreview: false,
        overlayOpacity: {{ old('overlay_opacity', 40) }},
        badgeColor: '{{ old('badge_color', '#f59e0b') }}',
        objectUrl: null,
        uploading: false,
        uploadProgress: 0,
        uploadError: null,
        previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            if (this.objectUrl) URL.revokeObjectURL(this.objectUrl);
            this.isVideoPreview = file.type.startsWith('video/');
            this.objectUrl = URL.createObjectURL(file);
            this.imagePreview = this.objectUrl;
        },
        clearPreview() {
            if (this.objectUrl) URL.revokeObjectURL(this.objectUrl);
            this.objectUrl = null;
            this.imagePreview = null;
            this.isVideoPreview = false;
            this.$refs.imageInput.value = '';
        },
        submitForm(event) {
            if (this.uploading) return;
            this.uploading = true;
            this.uploadProgress = 0;
            this.uploadError = null;

            const form = event.target;
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', form.action, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    this.uploadProgress = Math.round((e.loaded / e.total) * 100);
                }
            });

            xhr.onload = () => {
                this.uploading = false;
                let data = {};
                try { data = JSON.parse(xhr.responseText); } catch (e) {}

                if (xhr.status >= 200 && xhr.status < 300 && data.redirect) {
                    window.location.href = data.redirect;
                } else if (xhr.status === 422) {
                    if (data.errors) {
                        this.uploadError = Object.values(data.errors).flat().join(' ');
                    } else {
                        this.uploadError = data.message || 'Validation failed. Please check your input.';
                    }
                } else {
                    this.uploadError = data.message || ('Upload failed (server error ' + xhr.status + '). Please try again or use a smaller file.');
                }
            };

            xhr.onerror = () => {
                this.uploading = false;
                this.uploadError = 'Network error during upload. Check your connection and try again.';
            };

            xhr.send(formData);
        }
    }
}
</script>
@endpush

@endsection
