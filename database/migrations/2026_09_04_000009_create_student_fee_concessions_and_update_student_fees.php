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
        // 1. Add discount tracking columns to student_fees if not already present
        Schema::table('student_fees', function (Blueprint $table) {
            if (!Schema::hasColumn('student_fees', 'original_amount')) {
                $table->decimal('original_amount', 10, 2)->nullable()->after('amount');
            }
            if (!Schema::hasColumn('student_fees', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0.00)->after('original_amount');
            }
            if (!Schema::hasColumn('student_fees', 'discount_percent')) {
                $table->decimal('discount_percent', 5, 2)->default(0.00)->after('discount_amount');
            }
            if (!Schema::hasColumn('student_fees', 'paid_amount')) {
                $table->decimal('paid_amount', 10, 2)->nullable()->after('discount_percent');
            }
            if (!Schema::hasColumn('student_fees', 'discount_note')) {
                $table->string('discount_note')->nullable()->after('paid_amount');
            }
        });

        // 2. Create student_fee_concessions table for pre-set student-specific minus fee / discounts
        if (!Schema::hasTable('student_fee_concessions')) {
            Schema::create('student_fee_concessions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('school_id');
                $table->unsignedBigInteger('student_id');
                $table->unsignedBigInteger('fee_head_id');
                $table->enum('discount_type', ['fixed_amount', 'percentage', 'custom_fee'])->default('fixed_amount');
                $table->decimal('discount_amount', 10, 2)->default(0.00); // মাইনাস ফি / ছাড়
                $table->decimal('discount_percent', 5, 2)->default(0.00); // শতাংশ ছাড়
                $table->decimal('custom_amount', 10, 2)->nullable();     // সরাসরি নির্দিষ্ট ফি
                $table->string('note')->nullable();                       // কারণ / বিবরণ
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('fee_head_id')->references('id')->on('fee_heads')->onDelete('cascade');

                $table->unique(['school_id', 'student_id', 'fee_head_id'], 'unique_student_head_concession');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fee_concessions');

        Schema::table('student_fees', function (Blueprint $table) {
            $table->dropColumn([
                'original_amount',
                'discount_amount',
                'discount_percent',
                'paid_amount',
                'discount_note',
            ]);
        });
    }
};
