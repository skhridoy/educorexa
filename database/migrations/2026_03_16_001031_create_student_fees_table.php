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
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('fee_head_id');
            $table->decimal('amount', 10, 2);
            $table->string('month'); // e.g., "March-2026"
            $table->enum('status', ['paid', 'unpaid', 'partial'])->default('unpaid');
            $table->date('due_date')->nullable();
            $table->timestamps();

            // একই স্টুডেন্টের একই মাসে একই ফি হেড ডুপ্লিকেট হওয়া রোধ করতে
            $table->unique(['student_id', 'fee_head_id', 'month'], 'unique_student_billing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fees');
    }
};
