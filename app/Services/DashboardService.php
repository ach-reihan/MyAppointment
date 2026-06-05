<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Clinic;
use Carbon\Carbon;

class DashboardService
{
    public function getMacroStats(): array
    {
        // Ambil data asli dari Model
        $totalPasien = Patient::count();
        $totalDokter = Doctor::count();
        $janjiHariIni = Appointment::whereDate('appointment_datetime', Carbon::today())->count();
        $poliAktif = Clinic::count();

        // Anda bisa menambahkan logika perbandingan bulan lalu vs bulan ini untuk 'badge' jika mau
        // Untuk sekarang kita tampilkan nilai aktualnya
        return [
            [
                'label'   => 'Total Pasien',
                'value'   => number_format($totalPasien, 0, ',', '.'),
                'badge'   => 'Update',
                'badge_type' => 'success',
                'icon'    => 'users',
                'color'   => 'blue',
            ],
            [
                'label'   => 'Total Dokter',
                'value'   => $totalDokter,
                'badge'   => 'Aktif',
                'badge_type' => 'neutral',
                'icon'    => 'doctor',
                'color'   => 'indigo',
            ],
            [
                'label'   => 'Janji Temu Hari Ini',
                'value'   => $janjiHariIni,
                'badge'   => 'Hari Ini',
                'badge_type' => 'warning',
                'icon'    => 'calendar',
                'color'   => 'amber',
            ],
            [
                'label'   => 'Poli Aktif',
                'value'   => $poliAktif,
                'badge'   => 'Full Ops',
                'badge_type' => 'success',
                'icon'    => 'clinic',
                'color'   => 'emerald',
            ],
        ];
    }

    public function getWeeklyVisits(): array
    {
        // Contoh query untuk mengambil data 7 hari terakhir secara dinamis
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Appointment::whereDate('appointment_datetime', $date)->count();
            
            // Asumsi max kapasitas klinik per hari adalah 150 untuk persentase grafik (sesuaikan kebutuhan)
            $pct = ($count / 150) * 100; 

            $data[] = [
                'day'   => $date->translatedFormat('D'), // Sen, Sel, dll
                'count' => $count,
                'pct'   => min($pct, 100) // Maksimal tinggi bar 100%
            ];
        }
        return $data;
    }

    public function getRecentActivities(): array
    {
        // Ambil 4 janji temu terakhir yang paling baru di-update
        $recentAppointments = Appointment::latest('updated_at')->take(4)->get();
        
        $activities = [];
        foreach ($recentAppointments as $apt) {
            // Mapping status (asumsi ada kolom 'status' di tabel appointments)
            $activities[] = [
                'type'  => 'baru', // bisa disesuaikan dengan $apt->status (selesai, baru, dsb)
                'title' => 'Update Janji Temu',
                'desc'  => 'ID Janji: ' . substr($apt->id, 0, 8),
                'time'  => $apt->updated_at->format('H:i') . ' WIB',
                'color' => 'indigo',
            ];
        }

        return $activities;
    }
}