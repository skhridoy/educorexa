<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('payment_mode')->default('personal')->after('email');
            $table->string('bkash_personal_number')->nullable()->after('payment_mode');
            $table->string('nagad_personal_number')->nullable()->after('bkash_personal_number');
            $table->string('bkash_merchant_number')->nullable()->after('nagad_personal_number');
            $table->string('bkash_merchant_id')->nullable()->after('bkash_merchant_number');
            $table->text('bkash_api_key')->nullable()->after('bkash_merchant_id');
            $table->text('bkash_api_secret')->nullable()->after('bkash_api_key');
            $table->string('nagad_merchant_number')->nullable()->after('bkash_api_secret');
            $table->string('nagad_merchant_id')->nullable()->after('nagad_merchant_number');
            $table->text('nagad_api_key')->nullable()->after('nagad_merchant_id');
            $table->text('nagad_api_secret')->nullable()->after('nagad_api_key');
            $table->text('manual_payment_instructions')->nullable()->after('nagad_api_secret');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_mode', 'bkash_personal_number', 'nagad_personal_number',
                'bkash_merchant_number', 'bkash_merchant_id', 'bkash_api_key', 'bkash_api_secret',
                'nagad_merchant_number', 'nagad_merchant_id', 'nagad_api_key', 'nagad_api_secret',
                'manual_payment_instructions',
            ]);
        });
    }
};
