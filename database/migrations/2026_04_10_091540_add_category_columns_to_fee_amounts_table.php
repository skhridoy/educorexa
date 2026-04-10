<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('fee_amounts', function (Blueprint $table) {
            $table->unsignedBigInteger('school_category_id')->nullable()->after('class_id');
            $table->unsignedBigInteger('school_sub_category_id')->nullable()->after('school_category_id');

            // ফরেন কি সেট করা (অপশনাল কিন্তু ভালো প্র্যাকটিস)
            $table->foreign('school_category_id')->references('id')->on('school_categories')->onDelete('cascade');
            $table->foreign('school_sub_category_id')->references('id')->on('school_sub_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('fee_amounts', function (Blueprint $table) {
            $table->dropForeign(['school_category_id']);
            $table->dropForeign(['school_sub_category_id']);
            $table->dropColumn(['school_category_id', 'school_sub_category_id']);
        });
    }
};
