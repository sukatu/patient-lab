<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_number' => fake()->unique()->numerify('PAT-#####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->dateTimeBetween('-90 years', '-1 year'),
            'sex' => fake()->randomElement(['Female', 'Male', 'Non-binary']),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'city' => fake()->randomElement(['Accra', 'Kumasi', 'Tamale', 'Takoradi', 'Cape Coast']),
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']),
            'last_visit_at' => fake()->optional(0.85)->dateTimeBetween('-18 months', 'now'),
        ];
    }
}
