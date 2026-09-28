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
        Schema::table('exams', function (Blueprint $table) {
            if (!Schema::hasColumn('exams', 'admit_card_instruction')) {
                // পরীক্ষার প্রবেশপত্রে দেখানো নির্দেশনাবলী (প্রতি লাইনে একটি নির্দেশনা)
                $table->text('admit_card_instruction')->nullable()->after('end_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            if (Schema::hasColumn('exams', 'admit_card_instruction')) {
                $table->dropColumn('admit_card_instruction');
            }
        });
    }
};
