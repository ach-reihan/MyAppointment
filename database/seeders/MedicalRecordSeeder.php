<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $completedAppointments = Appointment::query()->where('status', 'completed')->get();

        foreach ($completedAppointments as $appointment) {
            MedicalRecord::factory()->create([
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'appointment_id' => $appointment->id,
                'checkup_date' => $appointment->appointment_datetime->format('Y-m-d'),
            ]);
        }
    }
}
