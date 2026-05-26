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
        $faker = fake('id_ID');
        $diagnoses = [
            'Infeksi saluran pernapasan ringan',
            'Gangguan pencernaan ringan',
            'Sakit kepala akibat kelelahan',
            'Nyeri otot karena aktivitas berlebih',
            'Radang tenggorokan',
            'Keluhan maag ringan',
            'Demam viral ringan',
        ];
        $prescriptions = [
            'Paracetamol 500 mg, Amoksisilin',
            'Ibuprofen 400 mg, Vitamin C',
            'Sirup obat batuk 3x1',
            'Antasida tablet, Minum setelah makan',
            'Obat flu dan istirahat cukup',
        ];

        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'appointment_id' => Appointment::factory(),
            'checkup_date' => $faker->date('Y-m-d'),
            'diagnosis' => $faker->randomElement($diagnoses),
            'action' => 'Memberikan perawatan ringan, istirahat, dan observasi lanjutan',
            'prescription' => $faker->randomElement($prescriptions),
        ];
    }
}