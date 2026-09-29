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
        // 1. Add custom_domain_yearly_fee to site_settings
        if (Schema::hasTable('site_settings')) {
            Schema::table('site_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('site_settings', 'custom_domain_yearly_fee')) {
                    $table->decimal('custom_domain_yearly_fee', 10, 2)->default(1500.00)->after('main_domain');
                }
            });
        }

        // 2. Add custom_domain_included to subscription_packages
        if (Schema::hasTable('subscription_packages')) {
            Schema::table('subscription_packages', function (Blueprint $table) {
                if (!Schema::hasColumn('subscription_packages', 'custom_domain_included')) {
                    $table->boolean('custom_domain_included')->default(false)->after('permissions');
                }
            });
        }

        // 3. Add payment and validity fields to schools table
        if (Schema::hasTable('schools')) {
            Schema::table('schools', function (Blueprint $table) {
                if (!Schema::hasColumn('schools', 'custom_domain_expires_at')) {
                    $table->timestamp('custom_domain_expires_at')->nullable()->after('custom_domain_verified_at');
                }
                if (!Schema::hasColumn('schools', 'custom_domain_payment_method')) {
                    $table->string('custom_domain_payment_method', 50)->nullable()->after('custom_domain_expires_at');
                }
                if (!Schema::hasColumn('schools', 'custom_domain_payment_sender')) {
                    $table->string('custom_domain_payment_sender', 50)->nullable()->after('custom_domain_payment_method');
                }
                if (!Schema::hasColumn('schools', 'custom_domain_payment_trx_id')) {
                    $table->string('custom_domain_payment_trx_id', 100)->nullable()->after('custom_domain_payment_sender');
                }
                if (!Schema::hasColumn('schools', 'custom_domain_payment_amount')) {
                    $table->decimal('custom_domain_payment_amount', 10, 2)->nullable()->after('custom_domain_payment_trx_id');
                }
                if (!Schema::hasColumn('schools', 'custom_domain_payment_status')) {
                    $table->string('custom_domain_payment_status', 30)->default('unpaid')->after('custom_domain_payment_amount');
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
                $columns = [
                    'custom_domain_expires_at',
                    'custom_domain_payment_method',
                    'custom_domain_payment_sender',
                    'custom_domain_payment_trx_id',
                    'custom_domain_payment_amount',
                    'custom_domain_payment_status',
                ];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('schools', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('subscription_packages')) {
            Schema::table('subscription_packages', function (Blueprint $table) {
                if (Schema::hasColumn('subscription_packages', 'custom_domain_included')) {
                    $table->dropColumn('custom_domain_included');
                }
            });
        }

        if (Schema::hasTable('site_settings')) {
            Schema::table('site_settings', function (Blueprint $table) {
                if (Schema::hasColumn('site_settings', 'custom_domain_yearly_fee')) {
                    $table->dropColumn('custom_domain_yearly_fee');
                }
            });
        }
    }
};
