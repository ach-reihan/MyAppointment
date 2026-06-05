<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Clinic;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $patients = Patient::query()->get();
        $doctors = Doctor::query()->get();
        $clinics = Clinic::query()->pluck('id')->all();
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        for ($i = 0; $i < 20; $i++) {
            $patient = $faker->randomElement($patients);
            $doctor = $faker->randomElement($doctors);
            $clinicId = $faker->randomElement($clinics);
            $status = ($i < 10) ? 'completed' : $faker->randomElement($statuses);

            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'clinic_id' => $clinicId,
                'appointment_datetime' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'status' => $status,
            ]);
        }
    }
}
