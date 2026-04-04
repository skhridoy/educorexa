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
        Schema::create('fee_amounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('fee_head_id');
            $table->unsignedBigInteger('class_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            // একই স্কুলে একই ক্লাসের জন্য একটি ফি হেড একবারই সেট করা যাবে
            $table->unique(['school_id', 'fee_head_id', 'class_id'], 'unique_fee_setup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_ammounts');
    }
};
