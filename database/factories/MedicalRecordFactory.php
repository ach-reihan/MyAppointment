<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'appointment_id' => Appointment::factory(),
            'checkup_date' => fake()->date('Y-m-d'),
            'diagnosis' => 'Pasien didiagnosa mengalami ' . fake()->word(),
            'action' => 'Memberikan perawatan ringan dan observasi',
            'prescription' => fake()->randomElement(['Paracetamol 500mg, Amoxicillin', 'Ibuprofen 400mg, Vitamin C', 'Sirup Obat Batuk 3x1']),
        ];
    }
}