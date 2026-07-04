@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-5">
                <div class="card p-6">
                    <h2 class="font-bold text-gray-800 mb-4">Product Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                class="input-field @error('name') border-red-500 @enderror" required />
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="5" class="input-field">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Specifications</label>
                            <textarea name="specifications" rows="6" class="input-field font-mono text-sm"
                                placeholder="Key: Value">{{ old('specifications', $product->specifications ? collect($product->specifications)->map(fn($v,$k) => "$k: $v")->implode("\n") : '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Existing Images --}}
                @if($product->images->isNotEmpty())
                    <div class="card p-6">
                        <h2 class="font-bold text-gray-800 mb-4">Current Images</h2>
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($product->images as $img)
                                <div class="relative group" id="img-wrap-{{ $img->id }}">
                                    <img src="{{ $img->url }}" alt="" class="w-full aspect-square object-cover rounded-lg border border-gray-200" />
                                    @if($img->is_primary)
                                        <span class="absolute top-1 left-1 badge bg-brand text-white text-xs">Primary</span>
                                    @endif
                                    <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button"
                                            onclick="askConfirm('Are you sure you want to remove this image?', () => submitDelete('{{ route('admin.products.image.delete', $img) }}', '{{ csrf_token() }}'), 'Remove Image')"
                                            class="w-6 h-6 bg-red-500 text-white rounded-full text-xs flex items-center justify-center">✕</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card p-6">
                    <h2 class="font-bold text-gray-800 mb-4">Add More Images</h2>
                    <input type="file" name="images[]" multiple accept="image/*" class="input-field py-2" />
                </div>

                {{-- Website Preview --}}
                <div class="card p-6 border-2 border-dashed border-indigo-200 bg-indigo-50/30">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <h2 class="font-bold text-gray-800">Website Preview</h2>
                    </div>

                    @if($product->has_preview)
                        <div class="mb-4 rounded-lg overflow-hidden border border-indigo-200 bg-white">
                            <div class="flex items-center justify-between px-3 py-2 bg-indigo-50 border-b border-indigo-100">
                                <div class="flex items-center gap-2 text-xs text-indigo-700">
                                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                                    Preview active &mdash; <code class="font-mono">{{ $product->preview_entry }}</code>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ $product->preview_url }}" target="_blank"
                                       class="text-xs text-indigo-600 hover:underline flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Open
                                    </a>
                                    <button type="button"
                                        onclick="askConfirm('Remove the website preview for this product?', () => submitDelete('{{ route('admin.products.preview.delete', $product->id) }}', '{{ csrf_token() }}'), 'Remove Preview')"
                                        class="text-xs text-red-500 hover:text-red-700 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <iframe src="{{ $product->preview_url }}" class="w-full border-0" style="height:220px;"
                                sandbox="allow-scripts allow-forms allow-popups" loading="lazy"></iframe>
                        </div>
                        <p class="text-xs text-gray-500 mb-3">Upload a new ZIP to replace the current preview.</p>
                    @else
                        <p class="text-xs text-gray-500 mb-3">Upload a ZIP file containing your HTML/CSS/JS website. Customers will see a live interactive preview on the product page.</p>
                    @endif

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $product->has_preview ? 'Replace Preview ZIP' : 'Preview ZIP File' }}
                    </label>
                    <input type="file" name="preview_zip" accept=".zip" class="input-field py-2" />
                    @error('preview_zip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <div class="mt-3 bg-white rounded-lg border border-indigo-100 p-3 text-xs text-gray-500 space-y-1">
                        <p class="font-medium text-gray-600">ZIP requirements:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            <li>Must contain an <code class="bg-gray-100 px-1 rounded">index.html</code> as the entry point</li>
                            <li>CSS, JS, images and fonts are all supported</li>
                            <li>Max size: 50 MB</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="card p-5">
                    <h2 class="font-bold text-gray-800 mb-4">Pricing</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price (K) *</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="input-field" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price (K)</label>
                            <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0" class="input-field" />
                        </div>
                    </div>
                </div>
                <div class="card p-5">
                    <h2 class="font-bold text-gray-800 mb-4">License Slots</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Available Slots *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="input-field" required />
                        <p class="text-xs text-gray-400 mt-1">Number of clients who can purchase this product</p>
                    </div>
                </div>

                <div class="card p-5">
                    <h2 class="font-bold text-gray-800 mb-4">Development Duration</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Duration *</label>
                        <select name="development_duration" class="input-field">
                            @foreach(['1 Week','2 Weeks','3 Weeks','4 Weeks','6 Weeks','8 Weeks','10 Weeks','12 Weeks'] as $dur)
                                <option value="{{ $dur }}" {{ old('development_duration', $product->development_duration ?? '3 Weeks') === $dur ? 'selected' : '' }}>
                                    {{ $dur }}{{ $dur === '3 Weeks' ? ' (Standard)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Used to calculate the client's project deadline upon order</p>
                    </div>
                </div>
                <div class="card p-5">
                    <h2 class="font-bold text-gray-800 mb-4">Organisation</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <select name="category_id" class="input-field" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                            <select name="brand_id" class="input-field">
                                <option value="">No Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select name="status" class="input-field">
                                <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="rounded text-brand" />
                            <span class="text-sm font-medium text-gray-700">Featured Product</span>
                        </label>
                    </div>
                </div>
                <div class="card p-5 border-2 border-dashed border-amber-200 bg-amber-50/30">
                    <h2 class="font-bold text-gray-800 mb-4">Promotion</h2>
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="cpp_enabled" value="1" {{ old('cpp_enabled', $product->cpp_enabled) ? 'checked' : '' }} class="rounded text-brand" />
                            <span class="text-sm font-medium text-gray-700">Enable Promotion</span>
                        </label>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Campaign</label>
                            <select name="cpp_promotion_id" class="input-field">
                                <option value="">None</option>
                                @foreach($promotions as $promo)
                                    <option value="{{ $promo->id }}" {{ old('cpp_promotion_id', $product->cpp_promotion_id) == $promo->id ? 'selected' : '' }}>{{ $promo->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Badge Text</label>
                            <input type="text" name="cpp_badge_text" value="{{ old('cpp_badge_text', $product->cpp_badge_text) }}" placeholder="e.g. Limited Offer" class="input-field" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Priority</label>
                            <input type="number" name="cpp_priority" value="{{ old('cpp_priority', $product->cpp_priority) }}" min="0" class="input-field" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Description</label>
                            <textarea name="cpp_description" rows="2" class="input-field">{{ old('cpp_description', $product->cpp_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary flex-1">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary flex-1 text-center">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
function submitDelete(url, token) {
    var f = document.createElement('form');
    f.method = 'POST';
    f.action = url;
    f.innerHTML = '<input type="hidden" name="_token" value="' + token + '">'
                + '<input type="hidden" name="_method" value="DELETE">';
    document.body.appendChild(f);
    f.submit();
}
</script>
@endpush
@endsection
