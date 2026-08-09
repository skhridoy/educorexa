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
            $table->boolean('is_admission_open')->default(true)->after('status');
            $table->text('admission_closed_message')->nullable()->after('is_admission_open');
            $table->dateTime('admission_close_date')->nullable()->after('admission_closed_message');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('admission_id')->nullable()->after('school_id')->constrained('admissions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['is_admission_open', 'admission_closed_message', 'admission_close_date']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['admission_id']);
            $table->dropColumn('admission_id');
        });
    }
};
