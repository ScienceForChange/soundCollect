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
        Schema::table('observations', function (Blueprint $table) {
            $table->decimal('temperature', 8, 2)->comment('format used: Celsius')->nullable();
            $table->integer('pressure')->comment('format used: Pascal')->nullable();
            $table->integer('humidity')->comment('format: g.m^3')->nullable();
            $table->decimal('wind_speed', 5, 2)->comment('format used: Meter/Sec')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            //
        });
    }
};
