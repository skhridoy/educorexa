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
        Schema::create('fee_heads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id')->constrained()->cascadeOnDelete();;
            $table->string('name')->unique(); // e.g., Monthly Fee
            $table->enum('type', ['monthly', 'once', 'recurring']); 
            $table->timestamps();

            $table->unique(['school_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_heads');
    }
};
