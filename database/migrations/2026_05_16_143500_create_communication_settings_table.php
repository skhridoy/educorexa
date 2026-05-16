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
        Schema::create('communication_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('event'); // e.g., 'fee_reminder', 'attendance', 'notice'
            $table->boolean('email_enabled')->default(false);
            $table->boolean('sms_enabled')->default(false);
            $table->boolean('whatsapp_enabled')->default(false);
            $table->text('email_template')->nullable();
            $table->text('sms_template')->nullable();
            $table->text('whatsapp_template')->nullable();
            $table->timestamps();

            // A school should only have one setting per event
            $table->unique(['school_id', 'event']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_settings');
    }
};
