@csrf
@if(isset($promotion)) @method('PUT') @endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">

        <div class="card p-6">
            <h2 class="font-bold text-gray-800 mb-4">Promotion Details</h2>
            <div class="space-y-4">
                <div>
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $promotion->title ?? '') }}" class="input-field" required />
                </div>
                <div>
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $promotion->subtitle ?? '') }}" class="input-field" />
                </div>
                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="input-field">{{ old('description', $promotion->description ?? '') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Instructions <span class="text-gray-400 font-normal text-xs">(one step per line — "How to Use CPP")</span></label>
                    <textarea name="instructions" rows="5" class="input-field font-mono text-sm" placeholder="Complete Order&#10;Receive Promotion Code&#10;Search Code&#10;Track Progress&#10;Wait for Contact">{{ old('instructions', isset($promotion) ? implode("\n", $promotion->instructions ?? []) : '') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Banner Image</label>
                    <input type="file" name="banner_image" accept="image/*" class="input-field py-2" />
                    @if(isset($promotion) && $promotion->banner_image)
                        <img src="{{ asset('storage/' . $promotion->banner_image) }}" class="mt-2 h-24 rounded-lg object-cover">
                    @endif
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h2 class="font-bold text-gray-800 mb-1">Eligible Products</h2>
            <p class="text-xs text-gray-500 mb-4">Select the products that qualify a customer for this promotion when purchased.</p>
            <div class="max-h-64 overflow-y-auto border border-gray-100 rounded-lg divide-y divide-gray-50">
                @foreach($products as $product)
                    @php $checked = isset($promotion) && $promotion->id === $product->cpp_promotion_id; @endphp
                    <label class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" {{ $checked ? 'checked' : '' }} class="rounded text-brand">
                        <span class="text-sm text-gray-700">{{ $product->name }}</span>
                        @if($product->cpp_promotion_id && $product->cpp_promotion_id !== ($promotion->id ?? null))
                            <span class="text-xs text-gray-400 ml-auto">Assigned to another promotion</span>
                        @endif
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div class="card p-5">
            <h2 class="font-bold text-gray-800 mb-4">Schedule &amp; Capacity</h2>
            <div class="space-y-3">
                <div>
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', optional($promotion->start_date ?? null)->format('Y-m-d')) }}" class="input-field" />
                </div>
                <div>
                    <label class="form-label">Expiry Date</label>
                    <input type="datetime-local" name="expiry_date" value="{{ old('expiry_date', optional($promotion->expiry_date ?? null)->format('Y-m-d\TH:i')) }}" class="input-field" />
                </div>
                <div>
                    <label class="form-label">Maximum Clients <span class="text-gray-400 font-normal text-xs">(blank = unlimited)</span></label>
                    <input type="number" name="max_clients" value="{{ old('max_clients', $promotion->max_clients ?? '') }}" min="1" class="input-field" />
                </div>
                <div>
                    <label class="form-label">Code Prefix</label>
                    <input type="text" name="code_prefix" value="{{ old('code_prefix', $promotion->code_prefix ?? '') }}" placeholder="CPP" class="input-field" />
                </div>
                <div>
                    <label class="form-label">Status *</label>
                    <select name="status" class="input-field">
                        @foreach(['draft','published','expired','closed'] as $s)
                            <option value="{{ $s }}" {{ old('status', $promotion->status ?? 'draft') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card p-5">
            <h2 class="font-bold text-gray-800 mb-4">Portal Options</h2>
            <div class="space-y-2">
                @foreach([
                    'enable_portal' => 'Enable Portal',
                    'allow_search' => 'Allow Search',
                    'show_client_counter' => 'Show Client Counter',
                    'show_remaining_slots' => 'Show Remaining Slots',
                    'show_timeline' => 'Show Timeline',
                    'auto_close' => 'Auto Close (when full)',
                    'auto_expire' => 'Auto Expire (past expiry date)',
                    'display_on_homepage' => 'Display on Homepage',
                ] as $flag => $label)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="{{ $flag }}" value="1"
                            {{ old($flag, $promotion->{$flag} ?? true) ? 'checked' : '' }}
                            class="rounded text-brand" />
                        <span class="text-sm text-gray-700">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary flex-1">Save Promotion</button>
            <a href="{{ route('admin.cpp.promotions.index') }}" class="btn-secondary flex-1 text-center">Cancel</a>
        </div>
    </div>
</div>
