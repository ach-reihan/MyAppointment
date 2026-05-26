<?php

namespace Database\Factories;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clinicName = fake()->randomElement(['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Penyakit Dalam', 'Poli Mata']);

        return [
            'name' => $clinicName,
            'description' => 'Pelayanan khusus untuk ' . $clinicName,
        ];
    }
}