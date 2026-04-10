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
        Schema::create('school_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_category_id')->constrained('school_categories')->onDelete('cascade');
            $table->string('name'); // e.g. Science, Commerce, Arts
            $table->timestamps();
        });

        // Student বা Class টেবিলে এটি যুক্ত করার প্রয়োজন হতে পারে
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('school_sub_category_id')->nullable()->constrained('school_sub_categories')->onDelete('set null')->after('academic_year_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_sub_categories');
    }
};
