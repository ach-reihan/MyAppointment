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
        $faker = fake('id_ID');

        return [
            'user_id' => User::factory()->patient(),
            'full_name' => $faker->name(),
            'address' => $faker->address(),
            'date_of_birth' => $faker->date('Y-m-d', '2010-01-01'),
            'phone_number' => '08' . $faker->numerify('##########'),
        ];
    }
}