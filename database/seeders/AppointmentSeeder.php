<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $clinics = Clinic::all();

        if ($patients->isEmpty() || $doctors->isEmpty() || $clinics->isEmpty()) {
            return;
        }

        Appointment::factory()
            ->count(20)
            ->recycle($patients)
            ->recycle($doctors)
            ->recycle($clinics)
            ->sequence(fn (Sequence $sequence) => [
                'status' => $sequence->index < 10 
                    ? 'completed' 
                    : fake()->randomElement(['pending', 'approved', 'completed', 'cancelled']),
            ])
            ->create();
    }
}
