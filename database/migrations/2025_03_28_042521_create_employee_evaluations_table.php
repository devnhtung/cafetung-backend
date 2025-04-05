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
        Schema::create('employee_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('evaluation_date'); // Ngày đánh giá
            $table->integer('rating')->nullable(); // Điểm đánh giá (1-5)
            $table->text('comments')->nullable(); // Nhận xét
            $table->foreignId('evaluated_by')->nullable()->constrained('users')->onDelete('set null'); // Người đánh giá (quản lý)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_evaluations');
    }
};
