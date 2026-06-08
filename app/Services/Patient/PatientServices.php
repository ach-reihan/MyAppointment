<?php

namespace App\Services\Patient;

use App\Models\Clinic;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Carbon\Carbon;

class PatientServices
{
    /**
     * Mengambil daftar poliklinik yang tersedia (Database)
     */
    public function getAllClinics()
    {
        return Clinic::where('status', 'AKTIF')
            ->with(['doctors.user'])
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($clinic) {
                return [
                    'id' => $clinic->id,
                    'name' => $clinic->name,
                    'doctors' => $clinic->doctors->map(function ($doctor) {
                        return [
                            'id' => $doctor->id,
                            'name' => $doctor->display_name,
                        ];
                    })->toArray(),
                ];
            })
            ->toArray();
    }

    /**
     * Mengambil detail janji temu berdasarkan ID (Database)
     */
    public function getAppointmentDetail($id)
    {
        $appt = Appointment::with(['doctor', 'clinic'])->find($id);
        if (!$appt) {
            return null;
        }

        return [
            'id' => $appt->id,
            'status' => $appt->status === 'pending' ? 'MENUNGGU' : ($appt->status === 'approved' ? 'DISETUJUI' : ($appt->status === 'completed' ? 'SELESAI' : 'DIBATALKAN')),
            'status_color' => $appt->status === 'pending' ? 'warning' : ($appt->status === 'approved' ? 'success' : ($appt->status === 'completed' ? 'info' : 'danger')),
            'doctor_name' => $appt->doctor ? $appt->doctor->display_name : 'Dokter',
            'clinic' => $appt->clinic ? $appt->clinic->name : 'Poliklinik',
            'date' => $appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('d F Y') : '-',
            'time' => $appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('H:i \W\I\B') : '-',
            'complaint' => $appt->complaint,
            'created_at' => $appt->created_at ? $appt->created_at->translatedFormat('d F Y, H:i \W\I\B') : '-'
        ];
    }

    /**
     * Mengambil daftar riwayat pemeriksaan pasien yang login (Database)
     */
    public function getPatientHistory()
    {
        $patient = $this->getPatientProfile();
        if (!$patient) {
            return [];
        }

        $history = [];

        // Ambil data janji temu yang selesai (completed) dan dibatalkan (cancelled)
        $appointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->with(['doctor', 'clinic', 'medicalRecord'])
            ->get();

        foreach ($appointments as $appt) {
            if ($appt->status === 'cancelled') {
                $history[] = [
                    'id' => $appt->id,
                    'is_cancelled' => true,
                    'date_raw' => $appt->appointment_datetime,
                    'date' => $appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('d F Y') : '-',
                    'time' => $appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('H:i \W\I\B') : '-',
                    'type' => 'Dibatalkan',
                    'doctor' => $appt->doctor ? $appt->doctor->display_name : 'Dokter',
                    'clinic' => $appt->clinic ? $appt->clinic->name : 'Poliklinik',
                    'diagnosis' => 'Pendaftaran Dibatalkan',
                    'treatment' => 'Tidak ada tindakan (Dibatalkan)',
                    'prescription' => 'Tidak ada resep obat',
                ];
            } else {
                $record = $appt->medicalRecord;
                $history[] = [
                    'id' => $appt->id,
                    'is_cancelled' => false,
                    'date_raw' => $record ? $record->checkup_date : $appt->appointment_datetime,
                    'date' => ($record && $record->checkup_date) ? $record->checkup_date->translatedFormat('d F Y') : ($appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('d F Y') : '-'),
                    'time' => ($record && $record->checkup_date) ? $record->checkup_date->translatedFormat('H:i \W\I\B') : ($appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('H:i \W\I\B') : '-'),
                    'type' => $record ? $record->diagnoses : 'Selesai',
                    'doctor' => $appt->doctor ? $appt->doctor->display_name : 'Dokter',
                    'clinic' => $appt->clinic ? $appt->clinic->name : 'Poliklinik',
                    'diagnosis' => $record ? $record->diagnoses : 'Pemeriksaan Selesai',
                    'treatment' => $record ? $record->action : 'Tidak ada tindakan (Selesai)',
                    'prescription' => $record ? $record->prescription : 'Tidak ada resep obat',
                ];
            }
        }

        // Urutkan berdasarkan tanggal terbaru (date_raw descending)
        usort($history, function ($a, $b) {
            $timeA = $a['date_raw'] ? $a['date_raw']->timestamp : 0;
            $timeB = $b['date_raw'] ? $b['date_raw']->timestamp : 0;
            return $timeB <=> $timeA;
        });

        return $history;
    }

    /**
     * Mengambil detail riwayat pemeriksaan berdasarkan ID (Database)
     */
    public function getHistoryDetail($id)
    {
        // 1. Cari berdasarkan Appointment ID terlebih dahulu
        $appt = Appointment::with(['doctor', 'clinic', 'medicalRecord'])->find($id);
        if ($appt) {
            if ($appt->status === 'cancelled') {
                return [
                    'id' => $appt->id,
                    'is_cancelled' => true,
                    'date' => $appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('d F Y') : '-',
                    'time' => $appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('H:i \W\I\B') : '-',
                    'type' => 'Dibatalkan',
                    'doctor' => $appt->doctor ? $appt->doctor->display_name : 'Dokter',
                    'clinic' => $appt->clinic ? $appt->clinic->name : 'Poliklinik',
                    'diagnosis' => 'Pendaftaran Dibatalkan',
                    'treatment' => 'Tidak ada tindakan (Dibatalkan)',
                    'prescription' => 'Tidak ada resep obat',
                ];
            } elseif ($appt->status === 'completed') {
                $record = $appt->medicalRecord;
                return [
                    'id' => $appt->id,
                    'is_cancelled' => false,
                    'date' => ($record && $record->checkup_date) ? $record->checkup_date->translatedFormat('d F Y') : ($appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('d F Y') : '-'),
                    'time' => ($record && $record->checkup_date) ? $record->checkup_date->translatedFormat('H:i \W\I\B') : ($appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('H:i \W\I\B') : '-'),
                    'type' => $record ? $record->diagnoses : 'Selesai',
                    'doctor' => $appt->doctor ? $appt->doctor->display_name : 'Dokter',
                    'clinic' => $appt->clinic ? $appt->clinic->name : 'Poliklinik',
                    'diagnosis' => $record ? $record->diagnoses : 'Pemeriksaan Selesai',
                    'treatment' => $record ? $record->action : 'Tidak ada tindakan (Selesai)',
                    'prescription' => $record ? $record->prescription : 'Tidak ada resep obat',
                ];
            }
        }

        // 2. Fallback: Cari di MedicalRecord langsung untuk id rekam medis lama (backward compatibility)
        $record = MedicalRecord::with(['doctor', 'appointment.clinic'])->find($id);
        if ($record) {
            return [
                'id' => $record->appointment_id ?? $record->id,
                'is_cancelled' => false,
                'date' => $record->checkup_date ? $record->checkup_date->translatedFormat('d F Y') : '-',
                'time' => $record->checkup_date ? $record->checkup_date->translatedFormat('H:i \W\I\B') : '-',
                'type' => $record->diagnoses,
                'doctor' => $record->doctor ? $record->doctor->display_name : 'Dokter',
                'clinic' => ($record->appointment && $record->appointment->clinic) ? $record->appointment->clinic->name : 'Poliklinik',
                'diagnosis' => $record->diagnoses,
                'treatment' => $record->action,
                'prescription' => $record->prescription,
            ];
        }

        return null;
    }

    /**
     * Mengambil data profil pasien yang login (Database)
     */
    public function getPatientProfile()
    {
        $user = auth()->user();
        return $user ? $user->patient : null;
    }

    /**
     * Mengambil daftar janji temu mendatang milik pasien yang login (Database)
     */
    public function getUpcomingAppointments()
    {
        $patient = $this->getPatientProfile();
        if (!$patient) {
            return [];
        }

        // Hanya tampilkan pending dan approved (cancelled sudah masuk riwayat)
        $appointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'approved'])
            ->with(['doctor', 'clinic'])
            ->orderBy('appointment_datetime', 'asc')
            ->get();

        return $appointments->map(function ($appt) {
            return [
                'id' => $appt->id,
                'doctor_name' => $appt->doctor ? $appt->doctor->display_name : 'Dokter',
                'clinic' => $appt->clinic ? $appt->clinic->name : 'Poliklinik',
                'date' => $appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('d M Y') : '-',
                'time' => $appt->appointment_datetime ? $appt->appointment_datetime->translatedFormat('H:i \W\I\B') : '-',
                'status' => match ($appt->status) {
                    'pending' => 'MENUNGGU',
                    'approved' => 'DISETUJUI',
                    default => strtoupper($appt->status)
                },
                'status_color' => match ($appt->status) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    default => 'secondary'
                }
            ];
        })->toArray();
    }
}