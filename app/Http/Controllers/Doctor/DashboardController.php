<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\Doctor\ExaminationServices; 

class DashboardController
{
   public function index(ExaminationServices $examinationService)
    {
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

        $doctorName = 'Dr. Healthink S.Ked, M.Ked'; 
        $polyclinic = 'Poli Umum';
        // 3. Kirim data yang sudah dihitung beserta data patients ke View
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