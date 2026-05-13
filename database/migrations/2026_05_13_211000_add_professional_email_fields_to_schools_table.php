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
        Schema::table('schools', function (Blueprint $table) {
            $table->enum('pro_email_status', ['none', 'pending', 'approved', 'rejected'])->default('none');
            $table->string('pro_email_address')->nullable();
            $table->string('pro_email_password')->nullable();
            $table->string('pro_email_prefix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['pro_email_status', 'pro_email_address', 'pro_email_password', 'pro_email_prefix']);
        });
    }
};
