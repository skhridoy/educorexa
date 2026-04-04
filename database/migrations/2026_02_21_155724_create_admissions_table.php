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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained('academicyears')->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->cascadeOnDelete();
            $table->string('admission_number')->unique();
            $table->string('name');
            $table->string('previous_school')->nullable();
            $table->string('previous_class')->nullable();

            $table->string('fathers_name');
            $table->string('mothers_name');
            $table->string('father_nid')->nullable();
            $table->string('mother_nid')->nullable();
            $table->string('student_birth_nid')->nullable();
            $table->string('contact_number');
            $table->string('password')->nullable();
            $table->string('photo')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
