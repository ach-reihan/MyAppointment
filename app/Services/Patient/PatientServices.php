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
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($clinic) {
                return [
                    'id' => $clinic->id,
                    'name' => $clinic->name
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
            'internal_note' => '', // Kolom ini tidak ada di database, dibiarkan kosong
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

        $records = MedicalRecord::where('patient_id', $patient->id)
            ->with(['doctor', 'appointment.clinic'])
            ->orderBy('checkup_date', 'desc')
            ->get();

        return $records->map(function ($record) {
            return [
                'id' => $record->id,
                'date' => $record->checkup_date ? $record->checkup_date->translatedFormat('d F Y') : '-',
                'time' => $record->checkup_date ? $record->checkup_date->translatedFormat('H:i \W\I\B') : '-',
                'type' => $record->diagnoses,
                'doctor' => $record->doctor ? $record->doctor->display_name : 'Dokter',
                'clinic' => ($record->appointment && $record->appointment->clinic) ? $record->appointment->clinic->name : 'Poliklinik',
                'diagnosis' => $record->diagnoses,
                'treatment' => $record->action,
                'prescription' => $record->prescription,
                'internal_note' => null
            ];
        })->toArray();
    }

    /**
     * Mengambil detail riwayat pemeriksaan berdasarkan ID (Database)
     */
    public function getHistoryDetail($id)
    {
        $record = MedicalRecord::with(['doctor', 'appointment.clinic'])->find($id);
        if (!$record) {
            return null;
        }

        return [
            'id' => $record->id,
            'date' => $record->checkup_date ? $record->checkup_date->translatedFormat('d F Y') : '-',
            'time' => $record->checkup_date ? $record->checkup_date->translatedFormat('H:i \W\I\B') : '-',
            'type' => $record->diagnoses,
            'doctor' => $record->doctor ? $record->doctor->display_name : 'Dokter',
            'clinic' => ($record->appointment && $record->appointment->clinic) ? $record->appointment->clinic->name : 'Poliklinik',
            'diagnosis' => $record->diagnoses,
            'treatment' => $record->action,
            'prescription' => $record->prescription,
            'internal_note' => null
        ];
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
                'status' => $appt->status === 'pending' ? 'MENUNGGU' : 'DISETUJUI',
                'status_color' => $appt->status === 'pending' ? 'warning' : 'success'
            ];
        })->toArray();
    }
}