<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Services\Patient\PatientServices;
use App\Models\Clinic;
use App\Models\Appointment;
use Carbon\Carbon;

class FormController
{
    protected $patientService;

    public function __construct(PatientServices $patientService)
    {
        $this->patientService = $patientService;
    }

    public function createAppointment()
    {
        $clinics = $this->patientService->getAllClinics();
        return view('patient.FormAppointment', compact('clinics'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'poliklinik' => 'required|exists:clinics,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
            'keluhan' => 'required|string|min:5',
        ], [
            'poliklinik.required' => 'Poliklinik wajib dipilih.',
            'poliklinik.exists' => 'Poliklinik tidak valid.',
            'tanggal.required' => 'Tanggal janji temu wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal janji temu tidak boleh di masa lalu.',
            'waktu.required' => 'Waktu janji temu wajib diisi.',
            'keluhan.required' => 'Keluhan utama wajib diisi.',
            'keluhan.min' => 'Keluhan utama minimal 5 karakter.',
        ]);

        $patient = $this->patientService->getPatientProfile();
        if (!$patient) {
            return back()->with('error', 'Profil pasien tidak ditemukan. Silakan login kembali.');
        }

        $clinic = Clinic::findOrFail($request->poliklinik);
        $doctor = $clinic->doctors()->first();

        if (!$doctor) {
            return back()->withErrors(['poliklinik' => 'Maaf, saat ini tidak ada dokter yang terhubung dengan poliklinik ini.'])->withInput();
        }

        $appointment_datetime = Carbon::parse($request->tanggal . ' ' . $request->waktu);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'appointment_datetime' => $appointment_datetime,
            'complaint' => $request->keluhan,
            'status' => 'pending',
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Janji temu Anda telah berhasil didaftarkan. Silakan datang ke klinik 15 menit sebelum waktu yang dijadwalkan.');
    }
}