@extends('layouts.admin')
@section('title', 'Add Product')

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Info --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="card p-6">
                    <h2 class="font-bold text-gray-800 mb-4">Product Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input-field @error('name') border-red-500 @enderror" required />
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="5" class="input-field">{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Specifications</label>
                            <textarea name="specifications" rows="6" class="input-field font-mono text-sm"
                                placeholder="Processor: Intel Core i7&#10;RAM: 16GB&#10;Storage: 512GB SSD">{{ old('specifications') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Format: Key: Value (one per line)</p>
                        </div>
                    </div>
                </div>

                {{-- Images --}}
                <div class="card p-6">
                    <h2 class="font-bold text-gray-800 mb-4">Product Images</h2>
                    <input type="file" name="images[]" multiple accept="image/*" class="input-field py-2" />
                    <p class="text-xs text-gray-400 mt-2">First image will be the primary image. Max 4MB each.</p>
                </div>

                {{-- Website Preview --}}
                <div class="card p-6 border-2 border-dashed border-indigo-200 bg-indigo-50/30">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <h2 class="font-bold text-gray-800">Website Preview <span class="text-xs font-normal text-indigo-500 ml-1">For website/template products</span></h2>
                    </div>
                    <p class="text-xs text-gray-500 mb-4">Upload a ZIP file containing your HTML/CSS/JS website. Customers will see a live interactive preview on the product page.</p>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Preview ZIP File</label>
                    <input type="file" name="preview_zip" accept=".zip" class="input-field py-2" />
                    @error('preview_zip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <div class="mt-3 bg-white rounded-lg border border-indigo-100 p-3 text-xs text-gray-500 space-y-1">
                        <p class="font-medium text-gray-600">ZIP requirements:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            <li>Must contain an <code class="bg-gray-100 px-1 rounded">index.html</code> as the entry point</li>
                            <li>CSS, JS, images and fonts are all supported</li>
                            <li>Can be a single folder or files at the root level</li>
                            <li>Max size: 50 MB</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                <div class="card p-5">
                    <h2 class="font-bold text-gray-800 mb-4">Pricing</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price (K) *</label>
                            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                class="input-field @error('price') border-red-500 @enderror" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price (K)</label>
                            <input type="number" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0" class="input-field" />
                            <p class="text-xs text-gray-400 mt-1">Leave empty if no sale</p>
                        </div>
                    </div>
                </div>

                <div class="card p-5">
                    <h2 class="font-bold text-gray-800 mb-4">License Slots</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Available Slots *</label>
                            <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0"
                                class="input-field @error('stock') border-red-500 @enderror" required />
                            <p class="text-xs text-gray-400 mt-1">Number of clients who can purchase this product</p>
                        </div>
                    </div>
                </div>

                <div class="card p-5">
                    <h2 class="font-bold text-gray-800 mb-4">Development Duration</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Duration *</label>
                        <select name="development_duration" class="input-field">
                            @foreach(['1 Week','2 Weeks','3 Weeks','4 Weeks','6 Weeks','8 Weeks','10 Weeks','12 Weeks'] as $dur)
                                <option value="{{ $dur }}" {{ old('development_duration', '3 Weeks') === $dur ? 'selected' : '' }}>
                                    {{ $dur }}{{ $dur === '3 Weeks' ? ' (Standard)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Shown to clients on the product page and used to calculate the project deadline</p>
                    </div>
                </div>

                <div class="card p-5">
                    <h2 class="font-bold text-gray-800 mb-4">Organisation</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <select name="category_id" class="input-field @error('category_id') border-red-500 @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                            <select name="brand_id" class="input-field">
                                <option value="">No Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select name="status" class="input-field">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                    class="rounded text-brand" />
                                <span class="text-sm font-medium text-gray-700">Featured Product</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card p-5 border-2 border-dashed border-amber-200 bg-amber-50/30">
                    <h2 class="font-bold text-gray-800 mb-4">Promotion</h2>
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="cpp_enabled" value="1" {{ old('cpp_enabled') ? 'checked' : '' }} class="rounded text-brand" />
                            <span class="text-sm font-medium text-gray-700">Enable Promotion</span>
                        </label>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Campaign</label>
                            <select name="cpp_promotion_id" class="input-field">
                                <option value="">None</option>
                                @foreach($promotions as $promo)
                                    <option value="{{ $promo->id }}" {{ old('cpp_promotion_id') == $promo->id ? 'selected' : '' }}>{{ $promo->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Badge Text</label>
                            <input type="text" name="cpp_badge_text" value="{{ old('cpp_badge_text') }}" placeholder="e.g. Limited Offer" class="input-field" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Priority</label>
                            <input type="number" name="cpp_priority" value="{{ old('cpp_priority', 0) }}" min="0" class="input-field" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Description</label>
                            <textarea name="cpp_description" rows="2" class="input-field">{{ old('cpp_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary flex-1">Save Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary flex-1 text-center">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
