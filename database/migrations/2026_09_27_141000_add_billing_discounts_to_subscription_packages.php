<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add billing_discounts column to subscription_packages
        if (Schema::hasTable('subscription_packages')) {
            Schema::table('subscription_packages', function (Blueprint $table) {
                if (!Schema::hasColumn('subscription_packages', 'billing_discounts')) {
                    // JSON: {"quarterly": 5, "half_yearly": 10, "yearly": 20}
                    if (Schema::hasColumn('subscription_packages', 'available_billing_periods')) {
                        $table->json('billing_discounts')->nullable()->after('available_billing_periods');
                    } else {
                        $table->json('billing_discounts')->nullable();
                    }
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('subscription_packages')) {
            Schema::table('subscription_packages', function (Blueprint $table) {
                if (Schema::hasColumn('subscription_packages', 'billing_discounts')) {
                    $table->dropColumn('billing_discounts');
                }
            });
        }
    }
};
