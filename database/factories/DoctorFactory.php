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
            'specialization' => 'Spesialis ' . $faker->randomElement([
                'Spesialis Penyakit Dalam',
                'Spesialis Bedah Umum',
                'Spesialis Anak',
                'Spesialis Obstetri dan Ginekologi',
                'Spesialis Saraf',
                'Spesialis Jantung dan Pembuluh Darah',
                'Spesialis Mata',
                'Spesialis THT',
                'Spesialis Kulit dan Kelamin',
                'Dokter Umum'
            ]),
        ];
    }
}