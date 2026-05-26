<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->name,
                'username' => 'doctor' . ($i + 1),
                'email' => 'doctor' . ($i + 1) . '@hospital.com',
                'password' => Hash::make('password'),
                'role' => 'doctor',
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => $faker->name,
                'username' => 'patient' . $i,
                'email' => 'patient' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'patient',
            ]);
        }
    }
}
