<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::factory()
            ->count(40)
            ->sequence(fn (Sequence $sequence) => [
                'user_id' => User::factory()->patient()->state([
                    'username' => 'patient' . ($sequence->index + 1),
                    'email' => 'patient' . ($sequence->index + 1) . '@gmail.com',
                ]),
            ])
            ->create();
    }
}
