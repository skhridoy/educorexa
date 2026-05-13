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
        Schema::table('schools', function (Blueprint $col) {
            // Email Settings
            $col->string('mail_mailer')->default('smtp')->after('logo');
            $col->string('mail_host')->nullable()->after('mail_mailer');
            $col->string('mail_port')->nullable()->after('mail_host');
            $col->string('mail_username')->nullable()->after('mail_port');
            $col->string('mail_password')->nullable()->after('mail_username');
            $col->string('mail_encryption')->nullable()->after('mail_password');
            $col->string('mail_from_address')->nullable()->after('mail_encryption');
            $col->string('mail_from_name')->nullable()->after('mail_from_address');

            // WhatsApp Settings
            $col->string('whatsapp_api_provider')->nullable()->after('mail_from_name');
            $col->string('whatsapp_api_key')->nullable()->after('whatsapp_api_provider');
            $col->string('whatsapp_api_instance_id')->nullable()->after('whatsapp_api_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $col) {
            $col->dropColumn([
                'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 
                'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name',
                'whatsapp_api_provider', 'whatsapp_api_key', 'whatsapp_api_instance_id'
            ]);
        });
    }
};
