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
        Schema::create('observation_type', function (Blueprint $table) {
            $table->id();
            $table->uuid('observation_id');

            $table->foreign('observation_id')->references('id')->on('observations');

            $table->unsignedBigInteger('type_id');

            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_type');
    }
};
