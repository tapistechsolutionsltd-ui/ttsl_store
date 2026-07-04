<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cpp_promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->json('instructions')->nullable();
            $table->string('banner_image')->nullable();
            $table->date('start_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->unsignedInteger('max_clients')->nullable();
            $table->enum('status', ['draft', 'published', 'expired', 'closed'])->default('draft');
            $table->boolean('enable_portal')->default(true);
            $table->boolean('allow_search')->default(true);
            $table->boolean('show_client_counter')->default(true);
            $table->boolean('show_remaining_slots')->default(true);
            $table->boolean('show_timeline')->default(true);
            $table->boolean('auto_close')->default(true);
            $table->boolean('auto_expire')->default(true);
            $table->boolean('display_on_homepage')->default(false);
            $table->string('code_prefix')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpp_promotions');
    }
};
