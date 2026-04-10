<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('school_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Primary, Secondary, etc.
            $table->integer('exams_per_year')->default(3); // ২ বা ৩
            $table->timestamps();
        });

        // বিদ্যমান classes টেবিলে রিলেশনশিপ যুক্ত করা
        Schema::table('classes', function (Blueprint $table) {
            $table->foreignId('school_category_id')->nullable()->constrained('school_categories')->onDelete('set null')->after('code');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_categories');
    }
};
