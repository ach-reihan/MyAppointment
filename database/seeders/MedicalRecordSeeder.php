<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $completedAppointments = Appointment::query()->where('status', 'completed')->get();

        foreach ($completedAppointments as $appointment) {
            MedicalRecord::create([
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'appointment_id' => $appointment->id,
                'checkup_date' => $appointment->appointment_datetime->format('Y-m-d'),
                'diagnosis' => 'Pasien didiagnosa mengalami ' . $faker->word,
                'action' => 'Memberikan perawatan ringan dan observasi',
                'prescription' => $faker->randomElement(['Paracetamol 500mg, Amoxicillin', 'Ibuprofen 400mg, Vitamin C', 'Sirup Obat Batuk 3x1']),
            ]);
        }
    }
}
