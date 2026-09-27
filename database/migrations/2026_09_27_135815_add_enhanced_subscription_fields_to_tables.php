<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add fields to subscription_packages table
        if (Schema::hasTable('subscription_packages')) {
            Schema::table('subscription_packages', function (Blueprint $table) {
                if (!Schema::hasColumn('subscription_packages', 'sort_order')) {
                    $table->integer('sort_order')->default(0)->after('name');
                }
                if (!Schema::hasColumn('subscription_packages', 'is_free')) {
                    $table->boolean('is_free')->default(false)->after('price');
                }
                if (!Schema::hasColumn('subscription_packages', 'service_fee')) {
                    $table->decimal('service_fee', 10, 2)->default(0.00)->after('is_free');
                }
                if (!Schema::hasColumn('subscription_packages', 'free_validity_period')) {
                    $table->string('free_validity_period', 20)->default('1_year')->after('service_fee'); // 6_months, 1_year
                }
                if (!Schema::hasColumn('subscription_packages', 'available_billing_periods')) {
                    $table->json('available_billing_periods')->nullable()->after('free_validity_period');
                }
            });
        }

        // 2. Add fields to school_subscriptions table
        if (Schema::hasTable('school_subscriptions')) {
            Schema::table('school_subscriptions', function (Blueprint $table) {
                if (!Schema::hasColumn('school_subscriptions', 'billing_period')) {
                    $table->string('billing_period', 30)->nullable()->after('currency'); // monthly, quarterly, half_yearly, yearly, free_6_months, free_1_year
                }
                if (!Schema::hasColumn('school_subscriptions', 'duration_months')) {
                    $table->unsignedSmallInteger('duration_months')->nullable()->after('billing_period'); // 1, 3, 6, 12
                }
                if (!Schema::hasColumn('school_subscriptions', 'payment_type')) {
                    $table->string('payment_type', 50)->nullable()->after('duration_months'); // service_fee, subscription_purchase, subscription_renewal, subscription_extension, upgrade
                }
            });
        }

        // 3. Safe Backfill for existing packages
        try {
            DB::table('subscription_packages')->where('price', '<=', 0)->update([
                'is_free' => true,
                'sort_order' => 1,
                'free_validity_period' => '1_year',
            ]);

            DB::table('subscription_packages')->where('price', '>', 0)->update([
                'is_free' => false,
                'sort_order' => 2,
                'available_billing_periods' => json_encode(['monthly', 'quarterly', 'half_yearly', 'yearly']),
            ]);

            // 4. Safe Backfill for existing subscriptions
            DB::table('school_subscriptions')->whereNull('billing_period')->update([
                'billing_period' => 'monthly',
                'duration_months' => 1,
                'payment_type' => 'subscription_purchase',
            ]);
        } catch (\Throwable $e) {
            // Ignore if in testing or table empty
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('school_subscriptions')) {
            Schema::table('school_subscriptions', function (Blueprint $table) {
                $columns = ['billing_period', 'duration_months', 'payment_type'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('school_subscriptions', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('subscription_packages')) {
            Schema::table('subscription_packages', function (Blueprint $table) {
                $columns = ['sort_order', 'is_free', 'service_fee', 'free_validity_period', 'available_billing_periods'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('subscription_packages', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
