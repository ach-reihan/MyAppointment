<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        User::factory()->admin()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@hospital.com',
        ]);

        for ($i = 0; $i < 5; $i++) {
            User::factory()->doctor()->create([
                'name' => $faker->name,
                'username' => 'doctor' . ($i + 1),
                'email' => 'doctor' . ($i + 1) . '@hospital.com',
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            User::factory()->patient()->create([
                'name' => $faker->name,
                'username' => 'patient' . $i,
                'email' => 'patient' . $i . '@gmail.com',
            ]);
        }
    }
}
