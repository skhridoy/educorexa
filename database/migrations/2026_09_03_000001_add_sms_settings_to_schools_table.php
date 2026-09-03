<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('sms_api_provider')->nullable()->after('whatsapp_api_instance_id');
            $table->string('sms_api_url')->nullable()->after('sms_api_provider');
            $table->string('sms_api_key')->nullable()->after('sms_api_url');
            $table->string('sms_api_secret')->nullable()->after('sms_api_key');
            $table->string('sms_sender_id')->nullable()->after('sms_api_secret');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'sms_api_provider', 'sms_api_url', 'sms_api_key',
                'sms_api_secret', 'sms_sender_id'
            ]);
        });
    }
};
