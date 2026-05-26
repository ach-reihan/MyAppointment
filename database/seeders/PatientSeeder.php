<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $patientUsers = User::query()->where('role', 'patient')->orderBy('id')->get();

        foreach ($patientUsers as $user) {
            Patient::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'address' => $faker->address,
                'date_of_birth' => $faker->date('Y-m-d', '2010-01-01'),
                'phone_number' => '08' . $faker->numerify('##########'),
            ]);
        }
    }
}
