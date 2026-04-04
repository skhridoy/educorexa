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
            $table->string('logo')->after('name')->nullable();
            $table->string('favicon')->after('logo')->nullable();
            $table->string('ein_number')->after('phone')->nullable();
             $table->string('emis_code')->after('ein_number')->nullable();
            $table->text('address')->after('emis_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            //
        });
    }
};
