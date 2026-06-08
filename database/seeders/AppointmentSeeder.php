<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::with('clinics')->get();
        $clinics = Clinic::all();

        if ($patients->isEmpty() || $doctors->isEmpty() || $clinics->isEmpty()) {
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $patient = $patients->random();
            $doctor = $doctors->random();
            $clinic = $doctor->clinics->isNotEmpty() 
                ? $doctor->clinics->random() 
                : $clinics->random();

            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'clinic_id' => $clinic->id,
                'status' => $i < 10 
                    ? 'completed' 
                    : fake()->randomElement(['pending', 'approved', 'completed', 'cancelled']),
            ]);
        }
    }
}
