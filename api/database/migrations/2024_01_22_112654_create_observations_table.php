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
            $table->id();
            // Screen 1
            $table->string('audio_param_1')->nullable(); //TODO: afinar
            $table->string('audio_param_2')->nullable(); //TODO: afinar
            $table->string('audio_param_3')->nullable(); //TODO: afinar
            $table->string('audio_param_4')->nullable(); //TODO: afinar
            // Screen 2
            $table->json('images')->nullable(); //TODO: afinar
            // Screen 3
            $table->string('sound_type')->nullable(); //TODO: afinar
            $table->string('sound_source')->nullable(); //TODO: afinar
            $table->string('sound_perception_enviroment')->nullable(); //TODO: afinar
            $table->text('comments')->nullable(); //TODO: afinar

            $table->unsignedBigInteger('user_id');
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
