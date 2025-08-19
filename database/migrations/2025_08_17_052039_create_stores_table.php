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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->double('latitude', 10, 6); // Độ chính xác cao cho tọa độ
            $table->double('longitude', 10, 6);
            $table->string('phone')->nullable();
            $table->json('opening_hours')->nullable(); // Ví dụ: {"mon": "08:00-22:00", "tue": "..."}
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
