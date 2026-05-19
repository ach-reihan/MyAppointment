<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $clinicsData = ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Penyakit Dalam', 'Poli Mata'];
        $clinics = [];
        foreach ($clinicsData as $clinicName) {
            $clinics[] = Clinic::create([
                'name' => $clinicName,
                'description' => 'Pelayanan khusus untuk ' . $clinicName,
            ]);
        }

        $doctors = [];
        $specializations = ['Umum', 'Gigi', 'Anak', 'Penyakit Dalam', 'Mata'];
        
        for ($i = 0; $i < 5; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => 'doctor' . ($i + 1),
                'email' => 'doctor' . ($i + 1) . '@hospital.com',
                'password' => Hash::make('password'),
                'role' => 'doctor',
            ]);

            $doctor = Doctor::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'specialization' => 'Spesialis ' . $specializations[$i],
            ]);

            $doctor->clinics()->attach(
                $faker->randomElements(collect($clinics)->pluck('id')->toArray(), rand(1, 2))
            );

            $doctors[] = $doctor;
        }

        $patients = [];
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => 'patient' . $i,
                'email' => 'patient' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'patient',
            ]);

            $patients[] = Patient::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'address' => $faker->address,
                'date_of_birth' => $faker->date('Y-m-d', '2010-01-01'),
                'phone_number' => '08' . $faker->numerify('##########'),
            ]);
        }

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        for ($i = 0; $i < 20; $i++) {
            $patient = $faker->randomElement($patients);
            $doctor = $faker->randomElement($doctors);
            
            $clinic_id = $doctor->clinics()->first()->id;
            
            $status = ($i < 10) ? 'completed' : $faker->randomElement($statuses);

            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'clinic_id' => $clinic_id,
                'appointment_datetime' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'complaint' => $faker->sentence(6),
                'status' => $status,
            ]);

            if ($status === 'completed') {
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
}