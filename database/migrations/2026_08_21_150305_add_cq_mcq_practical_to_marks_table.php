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
        Schema::table('marks', function (Blueprint $table) {
            $table->decimal('cq', 8, 2)->nullable()->after('marks');
            $table->decimal('mcq', 8, 2)->nullable()->after('cq');
            $table->decimal('practical', 8, 2)->nullable()->after('mcq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn(['cq', 'mcq', 'practical']);
        });
    }
};
