<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Observation>
 */
class ObservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "Leq" => "139",
            "LAeqT" => [
                "52",
                "126",
                "113",
                "76",
                "129"
            ],
            "LAmax" =>  "40",
            "LAmin" =>  "102",
            "L90" =>  "94",
            "L10" =>  "98",
            "sharpness_S" =>  "100",
            "loudness_N" =>  "112",
            "roughtness_R" =>  "20",
            "fluctuation_strength_F" =>  "34",
            "images" =>  null,
            "latitude" =>  $this->faker->randomFloat(6, '41.1877', '41.5172'),
            "longitude" =>  $this->faker->randomFloat(6, '1.9155', '2.3151'),
            "quiet" =>  "0",
            "cleanliness" =>  "0",
            "accessibility" =>  "0",
            "safety" =>  "0",
            "influence" =>  "0",
            "landmark" =>  "0",
            "protection" =>  "0",
            "wind_speed" =>  "6.17",
            "humidity" =>  48,
            "temperature" =>  "17.36",
            "pressure" =>  1006,
            "user_id" =>  \App\Models\User::all()->random()->id,
        ];
    }
}
