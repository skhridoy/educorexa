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
        Schema::table('assign_classes', function (Blueprint $table) {
           $table->string('full_mark')->nullable()->after('subject_id');
           $table->string('pass_mark')->nullable()->after('full_mark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assign_classes', function (Blueprint $table) {
            $table->dropColumn('full_mark');
            $table->dropColumn('pass_mark');
        });
    }
};
