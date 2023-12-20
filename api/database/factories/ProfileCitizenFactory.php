<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Citizen\Gender;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfileCitizen>
 */
class ProfileCitizenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'gender' => fake()->randomElement(Gender::cases()),
            'birth_year' => fake()->dateTimeBetween('-100 years', '-18 years'),
            'status_sentence' => fake()->sentence(),
            'deleted_because' => fake()->sentence(),
        ];
    }
}
