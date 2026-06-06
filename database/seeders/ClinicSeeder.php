<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinicsData = ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Penyakit Dalam', 'Poli Mata'];

        foreach ($clinicsData as $clinicName) {
            Clinic::create([
                'name' => $clinicName,
                'description' => 'Pelayanan khusus untuk ' . $clinicName,
            ]);
        }
    }
}
