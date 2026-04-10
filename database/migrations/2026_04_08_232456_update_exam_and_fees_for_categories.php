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
        // এক্সাম টেবিলে ক্যাটেগরি যোগ
        Schema::table('exams', function (Blueprint $table) {
            $table->unsignedBigInteger('school_category_id')->nullable()->after('school_id');
        });

        // ফি স্ট্রাকচার টেবিলে ক্যাটেগরি ও সাব-ক্যাটেগরি যোগ
        // যাতে ফর্ম ফিলাপ বা পরীক্ষার ফি নির্দিষ্ট গ্রুপে কাজ করে
        Schema::table('student_fees', function (Blueprint $table) {
            $table->unsignedBigInteger('school_category_id')->nullable()->after('school_id');
            $table->unsignedBigInteger('school_sub_category_id')->nullable()->after('school_category_id');
            
            // এটি 'global', 'class_wise' বা 'category_wise' ফি কি না তা চেনার জন্য
            $table->string('fee_type_limit')->default('global'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
