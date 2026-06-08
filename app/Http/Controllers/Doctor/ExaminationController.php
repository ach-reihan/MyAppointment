<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
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

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan');
        }

        // Ambil nama dokter dari sesi auth
        $user = Auth::user();
        $doctor = $user ? $user->doctor : Doctor::first();
        $doctorName = $doctor ? $doctor->display_name : 'Nama Dokter';

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

    public function store(Request $request, $id)
    {
        // Validasi data inputan
        $request->validate([
            'diagnoses'    => 'required|string',
            'action'       => 'required|string',
            'prescription' => 'required|string',
        ]);

        try {
            // Panggil service untuk memproses ke database
            $this->examinationService->storeExamination($id, $request->all());

            // Kembalikan respon JSON agar dibaca oleh fetch di Alpine.js
            return response()->json([
                'success' => true,
                'message' => 'Pemeriksaan pasien berhasil disimpan.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}