@extends('layouts.admin')
@section('title', 'CPP Settings')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.cpp.settings.update') }}" class="space-y-5">
        @csrf

        <div class="card p-6">
            <h2 class="font-bold text-gray-800 mb-4">Portal Behaviour</h2>
            <div class="space-y-2">
                @foreach([
                    'cpp_portal_enabled' => 'Portal Enabled',
                    'cpp_auto_generate_codes' => 'Auto Generate Codes',
                    'cpp_search_enabled' => 'Search Enabled',
                    'cpp_show_timeline' => 'Show Timeline',
                    'cpp_show_counters' => 'Show Counters',
                    'cpp_allow_public_status' => 'Allow Public Status',
                    'cpp_allow_countdown' => 'Allow Countdown',
                    'cpp_allow_statistics' => 'Allow Statistics',
                    'cpp_client_timeline_email_enabled' => 'Email Clients on Timeline Update',
                ] as $key => $label)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="{{ $key }}" value="1" {{ ($settings[$key] ?? '0') === '1' ? 'checked' : '' }} class="rounded text-brand" />
                        <span class="text-sm text-gray-700">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="card p-6">
            <h2 class="font-bold text-gray-800 mb-4">Code Generation</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Code Prefix</label>
                    <input type="text" name="cpp_code_prefix" value="{{ $settings['cpp_code_prefix'] ?? 'CPP' }}" class="input-field" />
                </div>
                <div>
                    <label class="form-label">Code Sequence Length</label>
                    <input type="number" name="cpp_code_length" min="3" max="8" value="{{ $settings['cpp_code_length'] ?? 4 }}" class="input-field" />
                </div>
                <div class="col-span-2">
                    <label class="form-label">Default Timeline Status for New Clients</label>
                    <select name="cpp_default_timeline" class="input-field">
                        @foreach(\App\Models\CppClient::TIMELINE_STATUSES as $key => $label)
                            <option value="{{ $key }}" {{ ($settings['cpp_default_timeline'] ?? 'application_received') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h2 class="font-bold text-gray-800 mb-4">Notifications</h2>
            <div>
                <label class="form-label">Admin Alert Email</label>
                <input type="email" name="cpp_alert_email" value="{{ $settings['cpp_alert_email'] ?? '' }}" class="input-field" />
            </div>
        </div>

        <button type="submit" class="btn-primary">Save Settings</button>
    </form>
</div>
@endsection
