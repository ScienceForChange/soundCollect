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
            $table->string('Leq')->nullable(); //TODO: afinar
            $table->string('LAeqT')->nullable(); //TODO: afinar
            $table->string('LAmax')->nullable(); //TODO: afinar
            $table->string('LAmin')->nullable(); //TODO: afinar
            $table->string('L90')->nullable(); //TODO: afinar
            $table->string('L10')->nullable(); //TODO: afinar
            $table->string('sharpness_S')->nullable(); //TODO: afinar
            $table->string('loudness_N')->nullable(); //TODO: afinar
            $table->string('roughtness_R')->nullable(); //TODO: afinar
            $table->string('fluctuation_strength_F')->nullable(); //TODO: afinar
            // Screen 2
            $table->json('images')->nullable(); //TODO: afinar
            // Screen 3
            $table->string('sound_type')->nullable(); //TODO: afinar
            $table->string('sound_source')->nullable(); //TODO: afinar
            $table->string('sound_perception_enviroment')->nullable(); //TODO: afinar
            $table->text('comments')->nullable(); //TODO: afinar

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
