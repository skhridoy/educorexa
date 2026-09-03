<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbound_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained('schools')->nullOnDelete();
            $table->string('mailbox_type', 20);
            $table->string('recipient_email');
            $table->string('message_id')->nullable()->unique();
            $table->string('sender_name')->nullable();
            $table->string('sender_email');
            $table->string('subject')->nullable();
            $table->longText('body_text')->nullable();
            $table->longText('body_html')->nullable();
            $table->json('headers')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->boolean('is_read')->default(false);
            $table->string('status', 20)->default('open');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['school_id', 'mailbox_type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbound_messages');
    }
};
