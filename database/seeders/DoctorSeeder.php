<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = ['Umum', 'Gigi', 'Anak', 'Penyakit Dalam', 'Mata'];
        $clinics = Clinic::all();

        if ($clinics->isEmpty()) {
            return;
        }

        Doctor::factory()
            ->count(10)
            ->sequence(fn (Sequence $sequence) => [
                'specialization' => 'Spesialis ' . $specializations[$sequence->index % count($specializations)],
                'user_id' => User::factory()->doctor()->state([
                    'username' => 'doctor' . ($sequence->index + 1),
                    'email' => 'doctor' . ($sequence->index + 1) . '@hospital.com',
                ]),
            ])
            ->afterCreating(function (Doctor $doctor) use ($clinics) {
                $doctor->clinics()->attach($clinics->random(rand(1, 2)));
            })
            ->create();
    }
}
