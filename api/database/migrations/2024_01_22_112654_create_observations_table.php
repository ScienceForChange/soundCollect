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
        Schema::create('observations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Screen 1
            $table->string('Leq')->nullable();
            $table->string('LAeqT')->nullable();
            $table->string('LAmax')->nullable();
            $table->string('LAmin')->nullable();
            $table->string('L90')->nullable();
            $table->string('L10')->nullable();
            $table->string('sharpness_S')->nullable();
            $table->string('loudness_N')->nullable();
            $table->string('roughtness_R')->nullable();
            $table->string('fluctuation_strength_F')->nullable();
            // Screen 2
            $table->json('images')->nullable();
            $table->decimal('longitude', 8, 5)->comment('longitude varies from 180.00000 to -180.00000, 5 decimal point means 1 meter precision');
            $table->decimal('latitude', 7, 5)->comment('latitude varies from 90.00000 to -90.00000, 5 deciamal point means 1 meter precision');
            // Screen 3
            $table->string('quiet')->nullable();
            $table->string('cleanliness')->nullable();
            $table->string('accessibility')->nullable();
            $table->string('safety')->nullable();
            $table->text('influence')->nullable();
            $table->text('landmark')->nullable();
            $table->text('protection')->nullable();

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
