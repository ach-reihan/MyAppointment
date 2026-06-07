<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Services\Patient\PatientServices;

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
}