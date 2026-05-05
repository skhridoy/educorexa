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
        Schema::table('subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('school_category_id')->nullable()->after('school_id');
            $table->unsignedBigInteger('school_sub_category_id')->nullable()->after('school_category_id');
            
            // Add foreign keys
            $table->foreign('school_category_id')
                  ->references('id')
                  ->on('school_categories')
                  ->onDelete('set null');
            $table->foreign('school_sub_category_id')
                  ->references('id')
                  ->on('school_sub_categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeignKey(['school_category_id']);
            $table->dropForeignKey(['school_sub_category_id']);
            $table->dropColumn(['school_category_id', 'school_sub_category_id']);
        });
    }
};
