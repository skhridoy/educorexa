<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
            $table->date('attendance_date');
            $table->string('status', 20)->default('present');
            $table->timestamp('scanned_at')->nullable();
            $table->timestamps();

            $table->unique(['exam_id', 'student_id', 'attendance_date'], 'exam_student_date_unique');
            $table->index(['school_id', 'exam_id', 'class_id', 'attendance_date'], 'exam_attendance_lookup_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_attendances');
    }
};
