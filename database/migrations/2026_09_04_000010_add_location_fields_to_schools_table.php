<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('division')->nullable()->after('address');
            $table->string('district')->nullable()->after('division');
            $table->string('upazila')->nullable()->after('district');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['division', 'district', 'upazila']);
        });
    }
};
