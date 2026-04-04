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
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained();
            $table->foreignId('class_id')->constrained();
            $table->foreignId('section_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('teacher_id')->constrained(); // কে ডায়েরি লিখছে
            $table->date('date'); // কোন দিনের ডায়েরি
            $table->text('lesson_description'); // আজকে কী পড়ানো হলো
            $table->text('homework')->nullable(); // আগামী দিনের পড়া বা বাড়ির কাজ
            $table->date('submission_date')->nullable(); // জমা দেওয়ার তারিখ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
