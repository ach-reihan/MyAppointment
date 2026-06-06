<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Services\Doctor\ExaminationServices; 

class ExaminationController 
{
    protected $examinationService;

    public function __construct(ExaminationServices $examinationService)
    {
        $this->examinationService = $examinationService;
    }

    public function index()
    {
        $patients = $this->examinationService->getTodayQueue();
        return view('doctor.examination.Index', compact('patients'));
    }

    public function show($id)
    {
        $patient = $this->examinationService->getPatientDetails($id);
        
        $histories = $this->examinationService->getMedicalHistory($id);
        $doctorName = 'Dr. Healthink S.Ked, M.Ked';

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan');
        }

        return view('doctor.examination.Show', compact('patient', 'histories', 'doctorName'));
    }

    public function detail($id)
    {
        $patient = $this->examinationService->getPatientDetails($id);
        $histories = $this->examinationService->getMedicalHistory($id);

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan');
        }

        return view('doctor.examination.Detail', compact('patient', 'histories'));
    }
}