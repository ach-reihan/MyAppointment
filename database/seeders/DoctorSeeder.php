<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $specializations = ['Umum', 'Gigi', 'Anak', 'Penyakit Dalam', 'Mata'];
        $clinicIds = Clinic::query()->pluck('id')->all();

        $doctorUsers = User::query()->where('role', 'doctor')->get();

        foreach ($doctorUsers->values() as $index => $user) {
            $specialization = $specializations[$index % count($specializations)];

            $doctor = Doctor::factory()->create([
                'user_id' => $user->id,
                'name' => 'Dr. ' . $user->name,
                'specialization' => 'Spesialis ' . $specialization,
            ]);

            if (! empty($clinicIds)) {
                $doctor->clinics()->attach(
                    $faker->randomElements($clinicIds, rand(1, 2))
                );
            }
        }
    }
}
