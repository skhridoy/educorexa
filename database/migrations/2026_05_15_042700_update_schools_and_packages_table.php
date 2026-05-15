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
        // 1. Update subscription_packages table to add permissions column
        if (Schema::hasTable('subscription_packages')) {
            Schema::table('subscription_packages', function (Blueprint $table) {
                if (!Schema::hasColumn('subscription_packages', 'permissions')) {
                    $table->json('permissions')->nullable()->after('features');
                }
            });
        }

        // 2. Update schools table to add subscription_package_id column
        if (Schema::hasTable('schools')) {
            Schema::table('schools', function (Blueprint $table) {
                if (!Schema::hasColumn('schools', 'subscription_package_id')) {
                    $table->unsignedBigInteger('subscription_package_id')->nullable()->after('status');
                    $table->foreign('subscription_package_id')->references('id')->on('subscription_packages')->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('schools')) {
            Schema::table('schools', function (Blueprint $table) {
                $table->dropForeign(['subscription_package_id']);
                $table->dropColumn('subscription_package_id');
            });
        }

        if (Schema::hasTable('subscription_packages')) {
            Schema::table('subscription_packages', function (Blueprint $table) {
                $table->dropColumn('permissions');
            });
        }
    }
};
