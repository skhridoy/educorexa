<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->boolean('imap_enabled')->default(false)->after('inbound_webhook_enabled');
            $table->string('imap_host')->nullable()->after('imap_enabled');
            $table->unsignedSmallInteger('imap_port')->default(993)->after('imap_host');
            $table->string('imap_username')->nullable()->after('imap_port');
            $table->text('imap_password')->nullable()->after('imap_username');
            $table->string('imap_encryption')->default('ssl')->after('imap_password');
            $table->string('imap_folder')->default('INBOX')->after('imap_encryption');
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('imap_enabled')->default(false)->after('inbound_webhook_enabled');
            $table->string('imap_host')->nullable()->after('imap_enabled');
            $table->unsignedSmallInteger('imap_port')->default(993)->after('imap_host');
            $table->string('imap_username')->nullable()->after('imap_port');
            $table->text('imap_password')->nullable()->after('imap_username');
            $table->string('imap_encryption')->default('ssl')->after('imap_password');
            $table->string('imap_folder')->default('INBOX')->after('imap_encryption');
        });
    }

    public function down(): void
    {
        foreach (['schools', 'site_settings'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['imap_enabled', 'imap_host', 'imap_port', 'imap_username', 'imap_password', 'imap_encryption', 'imap_folder']);
            });
        }
    }
};
