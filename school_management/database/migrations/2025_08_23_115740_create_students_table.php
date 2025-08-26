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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('student_name', 100);
            $table->string('student_password', 100);
            $table->string('student_email', 100)->unique();
            $table->string('image', 100)->nullable();
            $table->string('gender', 100);
            $table->string('address', 100);
            $table->string('phone', 100);
            $table->date('date_of_birth')->default('2000-01-01');
            $table->string('major', 100);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_graduate')->default(false);
            $table->date('enrollment_date');
            $table->date('graduation_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
