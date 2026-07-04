<?php

namespace App\Http\Controllers\Admin\Cpp;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private const KEYS = [
        'cpp_portal_enabled', 'cpp_auto_generate_codes', 'cpp_search_enabled',
        'cpp_show_timeline', 'cpp_show_counters', 'cpp_allow_public_status',
        'cpp_allow_countdown', 'cpp_allow_statistics', 'cpp_default_timeline',
        'cpp_code_prefix', 'cpp_code_length', 'cpp_alert_email', 'cpp_client_timeline_email_enabled',
    ];

    public function index()
    {
        $settings = Setting::getMany(self::KEYS);

        return view('admin.cpp.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'cpp_default_timeline' => 'required|string|max:50',
            'cpp_code_prefix'      => 'required|string|max:20',
            'cpp_code_length'      => 'required|integer|min:3|max:8',
            'cpp_alert_email'      => 'required|email',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        foreach ([
            'cpp_portal_enabled', 'cpp_auto_generate_codes', 'cpp_search_enabled',
            'cpp_show_timeline', 'cpp_show_counters', 'cpp_allow_public_status',
            'cpp_allow_countdown', 'cpp_allow_statistics', 'cpp_client_timeline_email_enabled',
        ] as $flag) {
            Setting::set($flag, $request->boolean($flag) ? '1' : '0');
        }

        return back()->with('success', 'CPP settings updated.');
    }
}
