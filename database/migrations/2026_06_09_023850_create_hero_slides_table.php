<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('badge_text', 100)->nullable();
            $table->string('badge_color', 30)->default('#f59e0b');
            $table->string('button_text', 100)->nullable();
            $table->string('button_url', 255)->nullable();
            $table->string('secondary_button_text', 100)->nullable();
            $table->string('secondary_button_url', 255)->nullable();
            $table->string('image_path')->nullable();
            $table->string('bg_color', 30)->default('#1e3a5f');
            $table->string('text_color', 30)->default('#ffffff');
            $table->unsignedTinyInteger('overlay_opacity')->default(50);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
