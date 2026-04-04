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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string(column: 'teacher_id')->unique();
            $table->string('name');
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->string('designation')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('nid')->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('blood_group')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('qualification')->nullable();
            $table->string('photo')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->unique(['school_id','email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
