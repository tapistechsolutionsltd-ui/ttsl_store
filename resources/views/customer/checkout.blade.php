@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold">Place Your Order</h1>
        <div class="flex items-center gap-4 mt-3 text-sm text-blue-100">
            <span class="flex items-center gap-1"><span class="w-6 h-6 bg-white text-brand rounded-full flex items-center justify-center text-xs font-bold">1</span> Client Details</span>
            <span>→</span>
            <span>2 Payment</span>
            <span>→</span>
            <span>3 Confirm</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <form method="POST" action="{{ route('checkout.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Client Info, Files & Payment --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Saved Addresses --}}
                @if($addresses->isNotEmpty())
                    <div class="card p-6">
                        <h2 class="font-bold text-gray-800 mb-4">Saved Client Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($addresses as $addr)
                                <label class="cursor-pointer">
                                    <input type="radio" name="use_address" value="{{ $addr->id }}" class="sr-only peer"
                                        @if($addr->is_default) checked @endif
                                        onchange="fillAddress({{ json_encode($addr) }})">
                                    <div class="border-2 rounded-xl p-4 peer-checked:border-brand peer-checked:bg-blue-50 hover:border-gray-300 transition-colors">
                                        <div class="font-semibold text-sm">{{ $addr->full_name }}</div>
                                        <div class="text-sm text-gray-500 mt-1">{{ $addr->full_address }}</div>
                                        <div class="text-sm text-gray-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> {{ $addr->phone }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Client Information --}}
                <div class="card p-6">
                    <h2 class="font-bold text-gray-800 mb-1">Client Information</h2>
                    <p class="text-xs text-gray-400 mb-4">Your contact details for project communication</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" name="full_name" id="addr_name" value="{{ old('full_name') }}"
                                class="input-field @error('full_name') border-red-500 @enderror" required />
                            @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" name="client_email" value="{{ old('client_email', auth()->user()->email) }}"
                                class="input-field @error('client_email') border-red-500 @enderror" required />
                            @error('client_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                            <input type="text" name="phone" id="addr_phone" value="{{ old('phone', auth()->user()->phone) }}"
                                class="input-field @error('phone') border-red-500 @enderror" required />
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company / Organisation <span class="font-normal text-gray-400">(optional)</span></label>
                            <input type="text" name="organisation" value="{{ old('organisation') }}"
                                class="input-field" placeholder="e.g. ABC Company Ltd" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                            <input type="text" name="country" id="addr_country" value="{{ old('country', 'Papua New Guinea') }}"
                                class="input-field" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Province *</label>
                            <select name="province" id="addr_province" class="input-field @error('province') border-red-500 @enderror" required>
                                <option value="">Select Province</option>
                                @foreach(['National Capital District','Central','Milne Bay','Oro','Southern Highlands','Enga','Western Highlands','Simbu','Eastern Highlands','Morobe','Madang','East Sepik','West Sepik','Manus','New Ireland','East New Britain','West New Britain','Bougainville','Western','Gulf'] as $prov)
                                    <option value="{{ $prov }}" {{ old('province') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                                @endforeach
                            </select>
                            @error('province') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City / Town *</label>
                            <input type="text" name="city" id="addr_city" value="{{ old('city') }}"
                                class="input-field @error('city') border-red-500 @enderror" required />
                            @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business / Home Address *</label>
                            <textarea name="address" id="addr_address" rows="2"
                                class="input-field @error('address') border-red-500 @enderror" required>{{ old('address') }}</textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Service / Technical Details --}}
                <div class="card p-6 border-l-4 border-brand bg-blue-50/30">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <h2 class="font-bold text-gray-800">Project &amp; Technical Details</h2>
                    </div>
                    <p class="text-xs text-gray-400 mb-4">Help us understand your project better so we can deliver exactly what you need.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Is this your first website? *</label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_first_website" value="1" class="text-brand"
                                        {{ old('is_first_website') === '1' ? 'checked' : '' }} required />
                                    <span class="text-sm">Yes, first website</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_first_website" value="0" class="text-brand"
                                        {{ old('is_first_website') === '0' ? 'checked' : '' }} />
                                    <span class="text-sm">No, I have an existing site</span>
                                </label>
                            </div>
                            @error('is_first_website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Existing Domain <span class="font-normal text-gray-400">(if any)</span></label>
                            <input type="text" name="existing_domain" value="{{ old('existing_domain') }}"
                                class="input-field" placeholder="e.g. www.mycompany.com.pg" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type of Website *</label>
                            <select name="website_type" class="input-field @error('website_type') border-red-500 @enderror">
                                <option value="">Select website type</option>
                                @foreach(['Business / Corporate','E-Commerce / Online Store','Portfolio / Personal','Blog / News','NGO / Non-Profit','Church / Ministry','Government / Municipal','School / Education','Restaurant / Food','Real Estate','Medical / Health','Booking / Appointment','Other'] as $wtype)
                                    <option value="{{ $wtype }}" {{ old('website_type') == $wtype ? 'selected' : '' }}>{{ $wtype }}</option>
                                @endforeach
                            </select>
                            @error('website_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Colour Scheme <span class="font-normal text-gray-400">(optional)</span></label>
                            <input type="text" name="preferred_colors" value="{{ old('preferred_colors') }}"
                                class="input-field" placeholder="e.g. Blue & White, Green & Gold" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Social Media Links <span class="font-normal text-gray-400">(optional)</span></label>
                            <textarea name="social_media_links" rows="2" class="input-field"
                                placeholder="Facebook: facebook.com/yourpage&#10;Instagram: @yourhandle">{{ old('social_media_links') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Provide links to your social media pages so we can align the website with your branding.</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Project Notes <span class="font-normal text-gray-400">(optional)</span></label>
                            <textarea name="notes" rows="3" class="input-field"
                                placeholder="Describe your project vision, specific features you want, pages you need, any references to websites you like...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Project Files Attachment (Required) --}}
                <div class="card p-6 border-2 border-brand/30 bg-brand/5">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        <h2 class="font-bold text-gray-800">Project Content &amp; Files <span class="text-red-500">*</span></h2>
                    </div>
                    <p class="text-xs text-gray-500 mb-4">Attach your content, logo, images, text, or any files needed for your project. This is required before your project can begin.</p>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Attach File <span class="text-red-500">*</span></label>
                    <input type="file" name="attachment_file" id="attachment_file"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.zip"
                        class="input-field py-2 @error('attachment_file') border-red-500 @enderror"
                        onchange="showFileName(this)" required />
                    @error('attachment_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p id="file-name-display" class="text-xs text-brand mt-1 hidden font-medium"></p>

                    <div class="mt-3 bg-white rounded-xl border border-brand/20 p-3 text-xs text-gray-500 space-y-1">
                        <p class="font-medium text-gray-600 mb-1.5">Accepted formats:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['PDF','Word (DOC/DOCX)','Images (JPG/PNG)','ZIP Archive'] as $fmt)
                                <span class="px-2 py-0.5 bg-gray-100 rounded-md font-medium text-gray-600">{{ $fmt }}</span>
                            @endforeach
                        </div>
                        <p class="pt-1">Max file size: <strong>25 MB</strong>. You can ZIP multiple files together.</p>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="card p-6">
                    <h2 class="font-bold text-gray-800 mb-4">Payment Method</h2>
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer has-[:checked]:border-brand has-[:checked]:bg-blue-50 hover:border-gray-300 transition-colors">
                            <input type="radio" name="payment_method" value="bank_transfer" class="mt-1" checked />
                            <div>
                                <div class="font-semibold flex items-center gap-2"><svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg> Bank Transfer</div>
                                <div class="text-sm text-gray-500 mt-1">Transfer to BSP / Kina Bank. Project begins after payment verification.</div>
                                <div class="text-sm text-gray-600 mt-2 bg-gray-50 p-3 rounded-lg space-y-1.5">
                                    <div><strong>Account Name:</strong> Jimmy Tapis</div>
                                    <div class="flex flex-wrap gap-x-5 gap-y-0.5">
                                        <span><strong>BSP Waigani:</strong> 7025374278</span>
                                        <span><strong>Kina Vision City:</strong> 32604018</span>
                                    </div>
                                    <div class="text-xs text-gray-500">Reference: Your project order number</div>
                                    <div class="pt-2 border-t border-gray-200 text-xs text-gray-500 italic leading-relaxed">
                                        Please note: Due to the ongoing finalisation of our business banking registration, all current transactions are processed through an authorised personal account. We appreciate your understanding. Should you have any questions regarding payment, please do not hesitate to contact us — we are happy to assist.
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer has-[:checked]:border-brand has-[:checked]:bg-blue-50 hover:border-gray-300 transition-colors">
                            <input type="radio" name="payment_method" value="cash_on_delivery" class="mt-1" />
                            <div>
                                <div class="font-semibold flex items-center gap-2"><svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Cash on Completion</div>
                                <div class="text-sm text-gray-500 mt-1">Pay in cash upon project completion and handover. Available in Port Moresby only.</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Right: Order Summary --}}
            <div class="space-y-4">
                <div class="card p-5 sticky top-24">
                    <h3 class="font-bold text-gray-800 mb-4">Project Summary</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto mb-4">
                        @foreach($cart->items as $item)
                            <div class="flex gap-3 text-sm">
                                <img src="{{ $item->product->primary_image_url }}" alt=""
                                     class="w-12 h-12 object-cover rounded-lg flex-shrink-0"
                                     onerror="this.src='https://via.placeholder.com/50?text=N/A'" />
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-700 truncate">{{ $item->product->name }}</p>
                                    <p class="text-gray-400 text-xs">Qty: {{ $item->quantity }}</p>
                                    @if(!empty($item->features))
                                        <ul class="text-xs text-gray-400 mt-0.5">
                                            @foreach($item->features as $f)
                                                <li>+ {{ $f['name'] }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if($item->product->development_duration)
                                        <p class="text-xs text-brand mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $item->product->development_duration }}
                                        </p>
                                    @endif
                                </div>
                                <span class="font-semibold text-gray-800 whitespace-nowrap">K {{ number_format($item->total, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t pt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span>K {{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if($discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Coupon Discount</span>
                                <span>−K {{ number_format($discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between font-bold text-lg border-t pt-3">
                            <span>Total</span>
                            <span class="text-brand">K {{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full py-4 text-lg mt-4">
                        Confirm &amp; Place Order →
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-3 flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Secure &amp; encrypted submission
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function fillAddress(addr) {
    document.getElementById('addr_name').value    = addr.full_name || '';
    document.getElementById('addr_phone').value   = addr.phone    || '';
    document.getElementById('addr_country').value = addr.country  || 'Papua New Guinea';
    document.getElementById('addr_province').value= addr.province || '';
    document.getElementById('addr_city').value    = addr.city     || '';
    document.getElementById('addr_address').value = addr.address  || '';
}
function showFileName(input) {
    const display = document.getElementById('file-name-display');
    if (input.files && input.files[0]) {
        display.textContent = '✓ ' + input.files[0].name;
        display.classList.remove('hidden');
    }
}
</script>
@endpush
