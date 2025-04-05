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
        Schema::create('shift_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('check_in_time')->nullable(); // Thời gian chấm công vào ca
            $table->timestamp('check_out_time')->nullable(); // Thời gian chấm công ra ca
            $table->integer('performance_rating')->nullable(); // Đánh giá hiệu suất (1-5)
            $table->text('manager_comments')->nullable(); // Nhận xét của quản lý
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_registrations');
    }
};
