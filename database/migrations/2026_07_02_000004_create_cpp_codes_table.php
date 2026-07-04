<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cpp_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpp_client_id')->constrained('cpp_clients')->cascadeOnDelete();
            $table->foreignId('cpp_promotion_id')->constrained('cpp_promotions')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->dateTime('generated_at');
            $table->dateTime('expires_at')->nullable();
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpp_codes');
    }
};
