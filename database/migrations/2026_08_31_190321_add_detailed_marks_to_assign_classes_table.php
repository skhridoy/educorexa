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
            $table->decimal('theory_full_mark', 8, 2)->nullable()->after('pass_mark');
            $table->decimal('theory_pass_mark', 8, 2)->nullable()->after('theory_full_mark');
            $table->decimal('practical_full_mark', 8, 2)->nullable()->after('theory_pass_mark');
            $table->decimal('practical_pass_mark', 8, 2)->nullable()->after('practical_full_mark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assign_classes', function (Blueprint $table) {
            $table->dropColumn([
                'theory_full_mark',
                'theory_pass_mark',
                'practical_full_mark',
                'practical_pass_mark'
            ]);
        });
    }
};
