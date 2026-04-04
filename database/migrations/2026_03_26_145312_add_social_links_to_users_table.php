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
        Schema::table('users', function (Blueprint $table) {
            $table->string('facebook')->after('phone')->nullable();
            $table->string('twitter')->after('facebook')->nullable();
            $table->string('linkedin')->after('twitter')->nullable();
            $table->string('insta')->after('linkedin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['facebook', 'twitter', 'linkedin', 'insta']);
        });
    }
};
