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
        Schema::table('teachers', function (Blueprint $table) {
            // Drop single column unique index on teacher_id if it exists
            try {
                $table->dropUnique('teachers_teacher_id_unique');
            } catch (\Throwable $e) {
                // Index might already be dropped or named differently
            }

            // Add composite unique index for school_id and teacher_id
            try {
                $table->unique(['school_id', 'teacher_id'], 'teachers_school_id_teacher_id_unique');
            } catch (\Throwable $e) {
                // Index might already exist
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            try {
                $table->dropUnique('teachers_school_id_teacher_id_unique');
            } catch (\Throwable $e) {
            }

            try {
                $table->unique('teacher_id', 'teachers_teacher_id_unique');
            } catch (\Throwable $e) {
            }
        });
    }
};
