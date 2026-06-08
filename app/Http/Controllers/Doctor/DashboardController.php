<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Services\Doctor\ExaminationServices; 

class DashboardController
{
   public function index(ExaminationServices $examinationService)
    {
        // 1. Ambil data pasien dari database (via Service)
        $patients = $examinationService->getTodayQueue();
        
        // 2. Lakukan perhitungan statistik
        $sisaAntrean = 0;
        $pasienSelesai = 0;

        foreach ($patients as $patient) {
            if ($patient['status'] === 'Menunggu') {
                $sisaAntrean++;
            } elseif ($patient['status'] === 'Selesai') {
                $pasienSelesai++;
            }
        }
        
        $totalJadwal = $sisaAntrean + $pasienSelesai;

        // 3. Ambil data Profil Dokter dari DB
        $user = Auth::user();
        $doctor = $user ? $user->doctor : Doctor::with('clinics')->first();
        
        $doctorName = $doctor ? $doctor->display_name : 'Nama Dokter Tidak Ditemukan';
        
        // Ambil klinik/poli pertama yang terhubung dengan dokter ini
        $polyclinic = 'Poli Umum'; // Fallback default
        if ($doctor && $doctor->clinics->count() > 0) {
            $polyclinic = $doctor->clinics->first()->name;
        }

        // 4. Kirim data yang sudah dihitung beserta data patients ke View
        return view('doctor.DashboardDoctor', compact(
            'patients', 
            'doctorName', 
            'polyclinic',
            'sisaAntrean', 
            'pasienSelesai', 
            'totalJadwal'
        ));
    }
}