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
        Schema::table('employee_details', function (Blueprint $table) {
            $table->text('experience')->nullable()->after('emergency_contact_phone');
            $table->json('skills')->nullable()->after('experience');
            $table->enum('status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active')->after('skills');
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            $table->dropColumn(['experience', 'skills', 'status', 'notes']);
        });
    }
};
