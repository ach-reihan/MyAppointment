<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $complaints = [
            'Demam sejak dua hari terakhir',
            'Batuk dan pilek yang tidak kunjung reda',
            'Sakit kepala disertai pusing',
            'Nyeri pada perut bagian bawah',
            'Badan terasa lemas dan tidak bertenaga',
            'Nyeri gigi saat mengunyah makanan',
            'Sesak napas saat aktivitas ringan',
            'Mual setelah makan',
        ];

        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'clinic_id' => Clinic::factory(),
            'appointment_datetime' => $faker->dateTimeBetween('-1 month', '+1 month'),
            'complaint' => $faker->randomElement($complaints),
            'status' => 'pending',
        ];
    }
}