<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_subscriptions', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('currency');
            $table->string('sender_number', 20)->nullable()->after('payment_method');
            $table->timestamp('payment_submitted_at')->nullable()->after('payment_reference');
            $table->foreignId('reviewed_by')->nullable()->after('payment_submitted_at')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            $table->text('rejection_reason')->nullable()->after('reviewed_at');
            $table->unique('payment_reference');
        });
    }

    public function down(): void
    {
        Schema::table('school_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropUnique(['payment_reference']);
            $table->dropColumn([
                'payment_method', 'sender_number', 'payment_submitted_at',
                'reviewed_by', 'reviewed_at', 'rejection_reason',
            ]);
        });
    }
};
