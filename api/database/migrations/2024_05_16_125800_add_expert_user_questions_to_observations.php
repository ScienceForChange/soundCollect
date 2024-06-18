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
            $table->string('pleasant')->nullable();
            $table->string('chaotic')->nullable();
            $table->string('vibrant')->nullable();
            $table->string('uneventful')->nullable();
            $table->string('calm')->nullable();
            $table->string('annoying')->nullable();
            $table->string('eventfull')->nullable();
            $table->string('monotonous')->nullable();
            $table->string('overall')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->dropColumn('path');
        });
    }
};

