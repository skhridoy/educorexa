<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the pivot table
        Schema::create('exam_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('school_category_id');
            $table->timestamps();

            $table->unique(['exam_id', 'school_category_id']);
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('school_category_id')->references('id')->on('school_categories')->onDelete('cascade');
        });

        // 2. Migrate existing data: copy school_category_id from exams → exam_categories
        $exams = DB::table('exams')->whereNotNull('school_category_id')->get(['id', 'school_category_id']);
        foreach ($exams as $exam) {
            DB::table('exam_categories')->insertOrIgnore([
                'exam_id'            => $exam->id,
                'school_category_id' => $exam->school_category_id,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_categories');
    }
};
