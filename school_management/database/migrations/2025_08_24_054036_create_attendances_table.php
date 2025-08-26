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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subject', 'subject_id')->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent'])->default('absent');
            $table->timestamps();
            
            // Unique constraint to prevent duplicate attendance records
            $table->unique(['student_id', 'subject_id', 'attendance_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
