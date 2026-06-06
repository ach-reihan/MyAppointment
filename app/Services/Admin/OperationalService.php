<?php

namespace App\Services\Admin;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use Carbon\Carbon;

class OperationalService
{
    /**
     * Data statistik antrian hari ini.
     */
    public function getQueueStats(): array
    {
        $today = Carbon::today();
        $appointments = Appointment::whereDate('appointment_datetime', $today)->get();

        $total = $appointments->count();
        $menunggu = $appointments->where('status', 'pending')->count();
        $proses = $appointments->where('status', 'approved')->count();
        $selesai = $appointments->where('status', 'completed')->count();

        // Hitung perbandingan persentase dengan hari kemarin
        $yesterdayCount = Appointment::whereDate('appointment_datetime', Carbon::yesterday())->count();
        $diff = $total - $yesterdayCount;
        $percent = $yesterdayCount > 0 ? round(($diff / $yesterdayCount) * 100) : ($total > 0 ? 100 : 0);
        $sign = $percent > 0 ? '+' : '';

        return [
            ['label' => 'Total Janji Temu', 'value' => $total, 'desc' => "{$sign}{$percent}% dari kemarin", 'color' => 'blue'],
            ['label' => 'Menunggu',         'value' => $menunggu, 'desc' => 'Pasien di ruang tunggu', 'color' => 'amber'],
            ['label' => 'Dalam Proses',     'value' => $proses,  'desc' => 'Sedang pemeriksaan',     'color' => 'indigo'],
            ['label' => 'Selesai',          'value' => $selesai, 'desc' => 'Pasien terlayani',       'color' => 'emerald'],
        ];
    }

    /**
     * Data tabel jadwal antrian hari ini.
     */
    public function getTodayQueue(): array
    {
        $today = Carbon::today();
        
        // Mengambil antrian hari ini beserta relasinya (Eager Loading)
        $appointments = Appointment::with(['patient.user', 'doctor.user', 'clinic'])
            ->whereDate('appointment_datetime', $today)
            ->orderBy('appointment_datetime', 'asc')
            ->get();

        return $appointments->map(function ($appt) {
            // Pemetaan status DB (Enum) ke format UI Anda
            $statusMap = [
                'pending'   => ['label' => 'Menunggu', 'color' => 'amber'],
                'approved'  => ['label' => 'Proses',   'color' => 'blue'],
                'completed' => ['label' => 'Selesai',  'color' => 'emerald'],
                'cancelled' => ['label' => 'Batal',    'color' => 'slate'],
            ];

            $statusData = $statusMap[$appt->status] ?? $statusMap['pending'];

            // Mengambil nama dari tabel relasi
            $patientName = $appt->patient->user->name ?? 'Pasien Anonim';
            $doctorName = $appt->doctor->user->name ?? 'Dokter Anonim';
            $poliName = $appt->clinic->name ?? 'Poli Umum';

            // Membuat inisial nama untuk avatar bundar
            $words = explode(' ', $patientName);
            $initial = '';
            if (isset($words[0])) $initial .= strtoupper(substr($words[0], 0, 1));
            if (isset($words[1])) $initial .= strtoupper(substr($words[1], 0, 1));

            return [
                // Frontend butuh ID singkat seperti #PX-2023, jadi kita ambil 8 karakter pertama ULID
                'id'      => '#' . strtoupper(substr($appt->id, 0, 8)), 
                'real_id' => $appt->id, // Disimpan untuk dikirim ke API saat aksi (Selesai/Hapus)
                'nama'    => $patientName,
                'dokter'  => $doctorName,
                'poli'    => $poliName,
                'waktu'   => Carbon::parse($appt->appointment_datetime)->translatedFormat('d M Y, H:i'),
                'status'  => $statusData['label'],
                'color'   => $statusData['color'],
                'initial' => $initial ?: 'PX'
            ];
        })->toArray();
    }

    /**
     * Data riwayat medis terakhir (Global).
     */
    public function getMedicalHistory(): array
    {
        $records = MedicalRecord::with(['doctor.user'])
            ->orderBy('checkup_at', 'desc')
            ->limit(5)
            ->get();

        return $records->map(function ($record) {
            return [
                'tanggal'  => Carbon::parse($record->checkup_at)->translatedFormat('d M Y'),
                'dokter'   => $record->doctor->user->name ?? 'Tidak Diketahui',
                'diagnosa' => $record->diagnoses,
                'tindakan' => $record->action,
                // Mengubah string resep menjadi array, memisahkan per baris/koma
                'resep'    => array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $record->prescription))))
            ];
        })->toArray();
    }
}