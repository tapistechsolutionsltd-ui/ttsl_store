<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->after('notes');
            $table->string('attachment_original_name')->nullable()->after('attachment_path');
            $table->date('development_due_date')->nullable()->after('attachment_original_name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['attachment_path', 'attachment_original_name', 'development_due_date']);
        });
    }
};
