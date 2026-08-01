<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->string('employee_id')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('designation')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('cnic')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('profile_photo')->nullable();
            $table->enum('employment_status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_profiles');
    }
};
