<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
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

        foreach ($specializations as $index => $specialization) {
            $doctor = Doctor::factory()->create([
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
