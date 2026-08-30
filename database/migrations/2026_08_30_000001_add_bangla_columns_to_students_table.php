<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * স্টুডেন্ট টেবিলে বাংলা ভাষার ফিল্ড যোগ করা হচ্ছে
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('name_bn')->nullable()->after('name');
            $table->string('fathers_name_bn')->nullable()->after('fathers_name');
            $table->string('mothers_name_bn')->nullable()->after('mothers_name');
            $table->text('address_bn')->nullable()->after('address');
            $table->string('previous_school_bn')->nullable()->after('previous_school');
            $table->string('previous_class_bn')->nullable()->after('previous_class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'name_bn',
                'fathers_name_bn',
                'mothers_name_bn',
                'address_bn',
                'previous_school_bn',
                'previous_class_bn',
            ]);
        });
    }
};
