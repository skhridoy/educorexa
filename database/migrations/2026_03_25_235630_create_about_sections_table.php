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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('feature_1_title')->nullable();
            $table->text('feature_1_desc')->nullable();
            $table->string('feature_2_title')->nullable();
            $table->text('feature_2_desc')->nullable();
            $table->string('image')->nullable();
            $table->string('button_text')->default('Details');
            $table->string('button_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
