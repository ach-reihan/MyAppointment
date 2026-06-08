<?php 

namespace App\Services\Doctor; 

use App\Models\Appointment; 
use App\Models\Doctor; 
use App\Models\MedicalRecord; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini untuk DB::transaction
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
            $statusUI = match ($appointment->status) {
                'pending' => 'Pending',
                'approved' => 'Disetujui',
                'completed' => 'Selesai',
                'cancelled' => 'Batal',
                default => ucfirst($appointment->status)
            };
            return [                 
                'id' => $appointment->id,                 
                'queue_number' => str_pad($index + 1, 3, '0', STR_PAD_LEFT),                 
                'phone' => $appointment->patient->phone_number ?? '-',                 
                'dob' => $appointment->patient->date_of_birth ? $appointment->patient->date_of_birth->format('Y-m-d') : '-',                 
                'name' => $appointment->patient->display_name,                 
                'insurance' => 'BPJS / Umum',                 
                'complaint' => $appointment->complaint,                 
                'status' => $statusUI,             
            ];         
        });     
    }     

    public function getPatientDetails($appointmentId)     
    {         
        $appointment = Appointment::with(['patient.user'])->find($appointmentId);         
        
        if (!$appointment) {             
            return null;         
        }         
        
        return [             
            'id' => $appointment->id,             
            'patient_id' => $appointment->patient_id,             
            'phone' => $appointment->patient->phone_number ?? '-',             
            'dob' => $appointment->patient->date_of_birth ? $appointment->patient->date_of_birth->format('d M Y') : '-',             
            'name' => $appointment->patient->display_name,             
            'insurance' => 'BPJS / Umum',             
            'complaint' => $appointment->complaint,             
            'status' => $appointment->status === 'completed' ? 'Selesai' : ($appointment->status === 'cancelled' ? 'Batal' : 'Menunggu'),         
        ];     
    }     

    public function getMedicalHistory($appointmentId)     
    {         
        $appointment = Appointment::find($appointmentId);                  
        
        if (!$appointment) {             
            return [];         
        }         
        
        $records = MedicalRecord::with(['doctor.user', 'appointment.clinic'])             
            ->where('patient_id', $appointment->patient_id)             
            ->orderBy('checkup_date', 'desc')             
            ->get();         
            
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
            ];         
        });     
    }     

    public function storeExamination($appointmentId, array $data)     
    {         
        return DB::transaction(function () use ($appointmentId, $data) {             
            // 1. Cari data antrean/appointment             
            $appointment = Appointment::findOrFail($appointmentId);             
            
            // 2. Buat data rekam medis baru             
            MedicalRecord::create([                 
                'patient_id'     => $appointment->patient_id,                 
                'doctor_id'      => $appointment->doctor_id,                 
                'appointment_id' => $appointment->id,                 
                'checkup_date'   => now(),                 
                'diagnoses'      => $data['diagnoses'] ?? '-',                 
                'action'         => $data['action'] ?? '-',                 
                'prescription'   => $data['prescription'] ?? '-',             
            ]);             
            
            // 3. Update status antrean menjadi 'completed'             
            $appointment->update([                 
                'status' => 'completed'             
            ]);             
            
            return $appointment;         
        });     
    } 

    public function approveAppointment($appointmentId)
    {
        $appt = Appointment::findOrFail($appointmentId);
        $appt->update(['status' => 'approved']);
        return $appt;
    }

    public function cancelAppointment($appointmentId)
    {
        $appt = Appointment::findOrFail($appointmentId);
        $appt->update(['status' => 'cancelled']);
        return $appt;
    }
}