<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
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
            'user_id' => User::factory()->doctor(),
            'name' => $faker->name(),
            'specialization' => 'Spesialis ' . $faker->randomElement(['Umum', 'Gigi', 'Anak', 'Penyakit Dalam', 'Mata']),
        ];
    }
}