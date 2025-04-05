<?php
// database/migrations/2025_03_28_000002_create_employee_details_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('full_name'); // Họ và tên
            $table->date('date_of_birth')->nullable(); // Ngày sinh
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Giới tính
            $table->string('phone_number')->nullable(); // Số điện thoại
            $table->text('address')->nullable(); // Địa chỉ
            $table->date('hire_date')->nullable(); // Ngày vào làm
            $table->string('national_id')->nullable(); // Số CMND/CCCD
            $table->string('bank_account')->nullable(); // Tài khoản ngân hàng
            $table->string('emergency_contact_name')->nullable(); // Tên người liên hệ khẩn cấp
            $table->string('emergency_contact_phone')->nullable(); // Số điện thoại người liên hệ khẩn cấp
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_details');
    }
}
