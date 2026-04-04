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
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('class_id');
            $table->string('student_id')->unique();
            $table->string('name');
            $table->string('previous_school')->nullable();
            $table->string('previous_class')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('father_nid')->nullable();
            $table->string('mother_nid')->nullable();
            $table->string('student_birth_nid')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->unique(['school_id','student_id']);
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
