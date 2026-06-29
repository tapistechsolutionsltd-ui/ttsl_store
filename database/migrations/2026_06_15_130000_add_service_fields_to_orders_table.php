<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('client_email')->nullable()->after('notes');
            $table->string('organisation')->nullable()->after('client_email');
            $table->string('existing_domain')->nullable()->after('organisation');
            $table->boolean('is_first_website')->nullable()->after('existing_domain');
            $table->string('website_type')->nullable()->after('is_first_website');
            $table->string('preferred_colors')->nullable()->after('website_type');
            $table->text('social_media_links')->nullable()->after('preferred_colors');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['client_email', 'organisation', 'existing_domain', 'is_first_website', 'website_type', 'preferred_colors', 'social_media_links']);
        });
    }
};
