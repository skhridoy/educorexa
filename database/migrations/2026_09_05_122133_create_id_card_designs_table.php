<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('id_card_designs', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                         // Display name e.g. "Royal Purple"
            $table->string('slug')->unique();                               // URL-safe e.g. "royal-purple"
            $table->string('header_shape')->nullable();                     // uploads/id_card_designs/{slug}/header_shape.png
            $table->string('gradient_bar')->nullable();                     // Bottom gradient bar image
            $table->string('pattern')->nullable();                          // Background pattern image
            $table->string('primary_color')->default('#6a1b9a');
            $table->string('badge_color')->default('#6a1b9a');
            $table->string('label_color')->default('#7b1fa2');
            $table->string('photo_border_color')->default('#ab47bc');
            $table->string('back_header_bg')->default('#f3e5f5');
            $table->string('back_header_text')->default('#6a1b9a');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('id_card_designs');
    }
};

