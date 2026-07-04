<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $defaults = [
            ['key' => 'cpp_portal_enabled', 'value' => '1'],
            ['key' => 'cpp_auto_generate_codes', 'value' => '1'],
            ['key' => 'cpp_search_enabled', 'value' => '1'],
            ['key' => 'cpp_show_timeline', 'value' => '1'],
            ['key' => 'cpp_show_counters', 'value' => '1'],
            ['key' => 'cpp_allow_public_status', 'value' => '1'],
            ['key' => 'cpp_allow_countdown', 'value' => '1'],
            ['key' => 'cpp_allow_statistics', 'value' => '1'],
            ['key' => 'cpp_default_timeline', 'value' => 'application_received'],
            ['key' => 'cpp_code_prefix', 'value' => 'CPP'],
            ['key' => 'cpp_code_length', 'value' => '4'],
            ['key' => 'cpp_alert_email', 'value' => 'ttsl.support@gmail.com'],
            ['key' => 'cpp_client_timeline_email_enabled', 'value' => '0'],
        ];

        foreach ($defaults as $row) {
            DB::table('settings')->updateOrInsert(
                ['key' => $row['key']],
                array_merge($row, ['created_at' => $now, 'updated_at' => $now])
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'like', 'cpp_%')->delete();
    }
};
