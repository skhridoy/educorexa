<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // কমিশনের ধরন: flat (প্রতি স্কুল নিবন্ধনে নির্দিষ্ট পরিমাণ) অথবা percentage (সাবস্ক্রিপশনের %)
            $table->enum('commission_type', ['flat', 'percentage'])->default('flat')->after('salary');
            // কমিশনের পরিমাণ (flat হলে টাকার অংক, percentage হলে % সংখ্যা)
            $table->decimal('commission_rate', 8, 2)->default(0)->after('commission_type');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['commission_type', 'commission_rate']);
        });
    }
};
