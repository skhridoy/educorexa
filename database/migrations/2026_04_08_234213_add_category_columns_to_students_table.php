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
        Schema::table('students', function (Blueprint $table) {
            // স্টুডেন্ট কোন ক্যাটেগরির (প্রাইমারি/মাধ্যমিক) তা চেনার জন্য
            $table->unsignedBigInteger('school_category_id')->nullable()->after('class_id');
            
            

            // ফরেন কি সেট করা (অপশনাল কিন্তু ভালো প্র্যাকটিস)
            $table->foreign('school_category_id')->references('id')->on('school_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['school_category_id']);
        });
    }
};
