<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('inbound_webhook_secret')->nullable()->after('sms_sender_id');
            $table->boolean('inbound_webhook_enabled')->default(false)->after('inbound_webhook_secret');
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('inbound_webhook_secret')->nullable()->after('mail_from_name');
            $table->boolean('inbound_webhook_enabled')->default(false)->after('inbound_webhook_secret');
        });
    }

    public function down(): void
    {
        Schema::table('schools', fn (Blueprint $table) => $table->dropColumn(['inbound_webhook_secret', 'inbound_webhook_enabled']));
        Schema::table('site_settings', fn (Blueprint $table) => $table->dropColumn(['inbound_webhook_secret', 'inbound_webhook_enabled']));
    }
};
