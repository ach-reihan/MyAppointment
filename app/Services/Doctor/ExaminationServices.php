<?php

namespace App\Services\Doctor;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExaminationServices
{
    public function getTodayQueue()
    {
        // Ambil data dokter yang sedang login (berdasarkan User)
        // Jika belum ada sistem auth, kita bisa pakai Doctor::first() untuk testing
        $user = Auth::user();
        $doctor = $user ? $user->doctor : Doctor::first(); 

        if (!$doctor) {
            return collect([]);
        }

        // Ambil jadwal hari ini
        $today = Carbon::today();

        $appointments = Appointment::with(['patient.user'])
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_datetime', $today)
            ->orderBy('appointment_datetime', 'asc')
            ->get();

        // Mapping data dari Database agar sesuai dengan format View yang sudah Anda buat
        return $appointments->map(function ($appointment, $index) {
            // Mapping status database ke status UI
            // Di database: 'pending', 'approved', 'cancelled', 'completed'
            $statusUI = 'Menunggu';
            if ($appointment->status === 'completed') {
                $statusUI = 'Selesai';
            } elseif ($appointment->status === 'cancelled') {
                $statusUI = 'Batal';
            }

            return [
                'id' => $appointment->id,
                'queue_number' => str_pad($index + 1, 3, '0', STR_PAD_LEFT), // Generate no antrean otomatis (001, 002, dst)
                'phone' => $appointment->patient->phone_number ?? '-',
                'dob' => $appointment->patient->date_of_birth ? $appointment->patient->date_of_birth->format('Y-m-d') : '-',
                'name' => $appointment->patient->display_name,
                'insurance' => 'BPJS / Umum', // Data ini belum ada di tabel migrations, di-hardcode sementara
                'complaint' => $appointment->complaint,
                'status' => $statusUI,
            ];
        });
    }

    public function getPatientDetails($appointmentId)
    {
        // Cari data antrean (appointment) berdasarkan ID, beserta relasi pasiennya
        $appointment = Appointment::with(['patient.user'])->find($appointmentId);

        if (!$appointment) {
            return null;
        }

        return [
            'id' => $appointment->id,
            'patient_id' => $appointment->patient_id, // Kita simpan untuk menarik riwayat rekam medis
            'phone' => $appointment->patient->phone_number ?? '-',
            'dob' => $appointment->patient->date_of_birth ? $appointment->patient->date_of_birth->format('d M Y') : '-',
            'name' => $appointment->patient->display_name,
            'insurance' => 'BPJS / Umum', // Fallback karena belum ada tabel asuransi
            'complaint' => $appointment->complaint,
            'status' => $appointment->status === 'completed' ? 'Selesai' : ($appointment->status === 'cancelled' ? 'Batal' : 'Menunggu'),
        ];
    }

    public function getMedicalHistory($appointmentId)
    {
        // Cari antrean saat ini untuk mengetahui siapa pasiennya
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment) {
            return [];
        }

        // Ambil riwayat rekam medis dari database berdasarkan patient_id
        // Urutkan dari yang paling baru diperiksa
        $records = MedicalRecord::with(['doctor.user', 'appointment.clinic'])
            ->where('patient_id', $appointment->patient_id)
            ->orderBy('checkup_date', 'desc')
            ->get();

        // Mapping data dari Database ke format View
        return $records->map(function ($record) {
            return [
                'id' => $record->id,
                'date' => \Carbon\Carbon::parse($record->checkup_date)->translatedFormat('d F Y'),
                'time' => \Carbon\Carbon::parse($record->checkup_date)->format('H:i') . ' WIB',
                'type' => 'Pemeriksaan Medis', 
                'doctor' => $record->doctor->display_name ?? 'Dokter Umum',
                'clinic' => $record->appointment->clinic->name ?? 'Poli Umum',
                'diagnosis' => $record->diagnoses,
                'treatment' => $record->action,
                'prescription' => $record->prescription,
                'internal_note' => '', 
            ];
        });
    }
}