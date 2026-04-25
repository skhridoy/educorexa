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
        Schema::create('frontend_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // যেমন: hero, about, pricing
            $table->string('title');         // ড্যাশবোর্ডে চেনার জন্য নাম
            $table->boolean('status')->default(1); // ১ = Active, ০ = Deactive
            $table->json('content')->nullable();   // ঐ সেকশনের টাইটেল, সাবটাইটেল বা ছবির পাথ
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
