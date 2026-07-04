<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('cpp_enabled')->default(false)->after('status');
            $table->foreignId('cpp_promotion_id')->nullable()->after('cpp_enabled')
                ->constrained('cpp_promotions')->nullOnDelete();
            $table->string('cpp_badge_text')->nullable()->after('cpp_promotion_id');
            $table->unsignedInteger('cpp_priority')->default(0)->after('cpp_badge_text');
            $table->text('cpp_description')->nullable()->after('cpp_priority');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cpp_promotion_id');
            $table->dropColumn(['cpp_enabled', 'cpp_badge_text', 'cpp_priority', 'cpp_description']);
        });
    }
};
