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
        Schema::table('fee_heads', function (Blueprint $table) {
            // ১. গ্লোবাল ইউনিক ইনডেক্সটি ড্রপ/মুছে ফেলুন
            $table->dropUnique('fee_heads_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee_heads', function (Blueprint $table) {
            // রোলব্যাক করলে আবার গ্লোবাল ইউনিক ইনডেক্স যোগ হবে
            $table->unique('name');
        });
    }
};