<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $now = now();
        $defaults = [
            // Mail / SMTP
            ['key' => 'mail_mailer',             'value' => 'log'],
            ['key' => 'mail_host',               'value' => '127.0.0.1'],
            ['key' => 'mail_port',               'value' => '587'],
            ['key' => 'mail_encryption',         'value' => 'tls'],
            ['key' => 'mail_username',           'value' => ''],
            ['key' => 'mail_password',           'value' => ''],
            ['key' => 'mail_from_address',       'value' => 'support@nextgenpng.net'],
            ['key' => 'mail_from_name',          'value' => 'Nextgen Store'],
            // Contact form routing
            ['key' => 'contact_recipient_email', 'value' => 'support@nextgenpng.net'],
            ['key' => 'contact_cc_email',        'value' => ''],
            ['key' => 'contact_subject_prefix',  'value' => '[NextGen Store]'],
            ['key' => 'contact_auto_reply',      'value' => '0'],
            ['key' => 'contact_auto_reply_msg',  'value' => 'Thank you for contacting NextGen Technology PNG. We have received your message and will respond within 24 business hours.'],
            // Store info
            ['key' => 'store_name',    'value' => 'Nextgen Store PNG'],
            ['key' => 'store_phone',   'value' => '+675 325 2023'],
            ['key' => 'store_email',   'value' => 'support@nextgenpng.net'],
            ['key' => 'store_address', 'value' => 'Port Moresby, Papua New Guinea'],
            ['key' => 'store_website', 'value' => 'https://www.nextgenpng.net'],
        ];

        DB::table('settings')->insert(
            array_map(fn($row) => array_merge($row, ['created_at' => $now, 'updated_at' => $now]), $defaults)
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
