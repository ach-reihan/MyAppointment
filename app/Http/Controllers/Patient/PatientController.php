<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Services\Patient\PatientServices;
class PatientController
{
    protected $patientService;
    public function __construct(PatientServices $patientService)
    {
        $this->patientService = $patientService;
    }

    public function dashboard()
    {
        $patient = $this->patientService->getPatientProfile();
        $histories = $this->patientService->getPatientHistory();
        $upcomingAppointments = $this->patientService->getUpcomingAppointments();

        return view('patient.DashboardPatient', compact('patient', 'histories', 'upcomingAppointments'));
    }

    public function showAppointmentDetail($id)
    {
        $appointment = $this->patientService->getAppointmentDetail($id);
        
        if (!$appointment) {
            abort(404, 'Detail Janji Temu tidak ditemukan');
        }
        
        return view('patient.AppointmentDetail', compact('appointment'));
    }

    public function medicalHistory()
    {
        $histories = $this->patientService->getPatientHistory();
        return view('patient.medicalhistory.MedicalHistoryList', compact('histories')); 
    }

    public function medicalHistoryDetail($id)
    {
        $history = $this->patientService->getHistoryDetail($id);
        $patient = $this->patientService->getPatientProfile();

        if (!$history) {
            abort(404, 'Riwayat tidak ditemukan');
        }

        return view('patient.medicalhistory.MedicalHistoryDetail', compact('history', 'patient'));
    }
}