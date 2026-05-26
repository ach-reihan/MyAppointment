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
        $doctorUsers = User::query()->where('role', 'doctor')->orderBy('id')->get();

        foreach ($doctorUsers as $index => $user) {
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'specialization' => 'Spesialis ' . $specializations[$index],
            ]);

            if (! empty($clinicIds)) {
                $doctor->clinics()->attach(
                    $faker->randomElements($clinicIds, rand(1, 2))
                );
            }
        }
    }
}
