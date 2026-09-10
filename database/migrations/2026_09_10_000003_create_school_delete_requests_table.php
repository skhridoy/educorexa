<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_delete_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            // যিনি ডিলিট রিকোয়েস্ট পাঠিয়েছেন (employee user)
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->text('reason')->nullable(); // ডিলিট করার কারণ
            // pending: অপেক্ষারত, approved: অনুমোদিত (স্কুল ডিলিট হবে), rejected: বাতিল
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            // যিনি রিভিউ করেছেন (super_admin বা HR)
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_note')->nullable(); // অ্যাডমিনের নোট (reject হলে কারণ)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_delete_requests');
    }
};
