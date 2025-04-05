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
        Schema::create('shift_registration_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->boolean('is_custom')->default(false); // Công việc bổ sung do quản lý thêm
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Trạng thái công việc
            $table->timestamp('completed_at')->nullable(); // Thời gian hoàn thành
            $table->timestamps();

            // Đảm bảo không trùng lặp: mỗi đăng ký ca chỉ có một công việc duy nhất
            $table->unique(['shift_registration_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_registration_tasks');
    }
};
