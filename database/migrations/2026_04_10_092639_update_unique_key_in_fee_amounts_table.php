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
            // ১. পুরানো ইউনিক কি টি ড্রপ করুন (আপনার এরর মেসেজ অনুযায়ী এটার নাম 'unique_fee_setup')
            $table->dropUnique('unique_fee_setup');

            // ২. নতুন কলামগুলোসহ ইউনিক কি সেট করুন
            $table->unique([
                'school_id', 
                'fee_head_id', 
                'class_id', 
                'school_category_id', 
                'school_sub_category_id'
            ], 'unique_fee_setup_v2');
        });
    }

    public function down()
    {
        Schema::table('fee_amounts', function (Blueprint $table) {
            $table->dropUnique('unique_fee_setup_v2');
            
            // রিভার্স করার সময় আগের অবস্থায় ফিরে যাওয়া
            $table->unique(['school_id', 'fee_head_id', 'class_id'], 'unique_fee_setup');
        });
    }
};
