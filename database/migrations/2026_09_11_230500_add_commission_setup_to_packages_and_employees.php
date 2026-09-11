<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ১. subscription_packages টেবিলে প্যাকেজ-ভিত্তিক রেজিস্ট্রেশন ও মাসিক কমিশন ফিল্ড
        Schema::table('subscription_packages', function (Blueprint $table) {
            // নতুন স্কুল রেজিস্ট্রেশন কমিশন (flat অথবা percentage)
            $table->enum('registration_commission_type', ['flat', 'percentage'])->default('flat')->after('price');
            $table->decimal('registration_commission_rate', 10, 2)->default(0)->after('registration_commission_type');

            // মাসিক এক্সট্রা কমিশন (স্কুল প্রতি মাসে রিনিউ/চলতি থাকলে)
            $table->enum('monthly_commission_type', ['flat', 'percentage'])->default('flat')->after('registration_commission_rate');
            $table->decimal('monthly_commission_rate', 10, 2)->default(0)->after('monthly_commission_type');
        });

        // ২. employees টেবিলে মাসিক রিকারিং কমিশন ফিল্ড যোগ করা (যাতে প্রতিনিধি-ভিত্তিক স্পেসিফিক রেটও রাখা যায়)
        Schema::table('employees', function (Blueprint $table) {
            $table->enum('monthly_commission_type', ['flat', 'percentage'])->default('flat')->after('commission_rate');
            $table->decimal('monthly_commission_rate', 10, 2)->default(0)->after('monthly_commission_type');
        });
    }

    public function down(): void
    {
        Schema::table('subscription_packages', function (Blueprint $table) {
            $table->dropColumn([
                'registration_commission_type',
                'registration_commission_rate',
                'monthly_commission_type',
                'monthly_commission_rate',
            ]);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'monthly_commission_type',
                'monthly_commission_rate',
            ]);
        });
    }
};
