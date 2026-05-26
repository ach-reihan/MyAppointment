<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
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
            'user_id' => User::factory()->patient(),
            'full_name' => fake()->name(),
            'address' => fake()->address(),
            'date_of_birth' => fake()->date('Y-m-d', '2010-01-01'),
            'phone_number' => '08' . fake()->numerify('##########'),
        ];
    }
}