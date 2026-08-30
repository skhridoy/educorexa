<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Drop single column unique index on student_id if it exists
        try {
            Schema::table('students', function (Blueprint $table) {
                $table->dropUnique('students_student_id_unique');
            });
        } catch (\Throwable $e) {
            // Index might already be dropped or named differently
        }

        // 2. Ensure composite unique index for school_id and student_id exists
        try {
            Schema::table('students', function (Blueprint $table) {
                $table->unique(['school_id', 'student_id'], 'students_school_id_student_id_unique');
            });
        } catch (\Throwable $e) {
            // Index already exists
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('students', function (Blueprint $table) {
                $table->dropUnique('students_school_id_student_id_unique');
            });
        } catch (\Throwable $e) {
        }

        try {
            Schema::table('students', function (Blueprint $table) {
                $table->unique('student_id', 'students_student_id_unique');
            });
        } catch (\Throwable $e) {
        }
    }
};
