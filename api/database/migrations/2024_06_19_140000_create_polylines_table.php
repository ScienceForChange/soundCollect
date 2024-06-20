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
        Schema::create('polylines', function (Blueprint $table) {

            $table->id();

            $table->uuid('observation_id');
            $table->foreign('observation_id')->references('id')->on('observations');

            $table->integer('position')->comment('position of the polyline observation in the route');

            $table->decimal('start_latitude', 7, 5)->comment('latitude varies from 90.00000 to -90.00000, 5 deciamal point means 1 meter precision');
            $table->decimal('start_longitude', 8, 5)->comment('longitude varies from 180.00000 to -180.00000, 5 decimal point means 1 meter precision');
            $table->decimal('end_latitude', 7, 5)->comment('latitude varies from 90.00000 to -90.00000, 5 deciamal point means 1 meter precision');
            $table->decimal('end_longitude', 8, 5)->comment('longitude varies from 180.00000 to -180.00000, 5 decimal point means 1 meter precision');

            $table->integer('L90')->nullable();
            $table->integer('L10')->nullable();
            $table->integer('LAmax')->nullable();
            $table->integer('LAmin')->nullable();
            $table->integer('LAeq')->nullable();
            $table->json('LAeqT')->nullable();
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
