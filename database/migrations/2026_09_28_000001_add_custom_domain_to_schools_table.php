<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('custom_domain')->nullable()->unique()->after('slug')
                  ->comment('কাস্টম ডোমেইন যেমন: school.example.com');
            $table->enum('custom_domain_status', ['none', 'pending', 'verified', 'rejected', 'disabled'])
                  ->default('none')->after('custom_domain')
                  ->comment('ডোমেইন ভেরিফিকেশন স্ট্যাটাস');
            $table->text('custom_domain_reject_reason')->nullable()->after('custom_domain_status')
                  ->comment('সুপার এডমিনের reject কারণ');
            $table->timestamp('custom_domain_verified_at')->nullable()->after('custom_domain_reject_reason');
            $table->string('custom_domain_ssl_status')->nullable()->default('pending')
                  ->after('custom_domain_verified_at')
                  ->comment('SSL সার্টিফিকেট স্ট্যাটাস: pending, active, failed');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'custom_domain',
                'custom_domain_status',
                'custom_domain_reject_reason',
                'custom_domain_verified_at',
                'custom_domain_ssl_status',
            ]);
        });
    }
};
