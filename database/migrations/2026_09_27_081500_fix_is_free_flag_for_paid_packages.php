<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix packages that have a non-zero price but is_free = true.
     * This can happen when a package was created/backfilled with price=0 and
     * then later updated to have a price through the admin panel, but is_free
     * was not properly reset.
     */
    public function up(): void
    {
        DB::table('subscription_packages')
            ->where('is_free', true)
            ->where('price', '>', 0)
            ->update([
                'is_free'    => false,
                'service_fee' => 0.00,
            ]);
    }

    public function down(): void
    {
        // No safe reverse
    }
};
