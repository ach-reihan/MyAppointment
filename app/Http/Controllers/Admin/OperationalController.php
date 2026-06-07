<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\OperationalService;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Clinic;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OperationalController 
{
    public function __construct(
        protected OperationalService $operationalService
    ) {}

    public function queue(): View
    {
        return view('admin.operational.queue', [
            'stats'    => $this->operationalService->getQueueStats(),
            'queues'   => $this->operationalService->getTodayQueue(),
            'history'  => $this->operationalService->getMedicalHistory(),
            
            // Tambahan: Kirim data master ke view untuk Dropdown di form modal
            'patients' => Patient::with('user')->get(),
            'doctors'  => Doctor::with('user')->get(),
            'clinics'  => Clinic::all(),
        ]);
    }

    public function storeQueue(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'patient_id'           => 'required|string|exists:patients,id',
            'doctor_id'            => 'required|string|exists:doctors,id',
            'clinic_id'            => 'required|string|exists:clinics,id',
            'appointment_datetime' => 'required|date|after_or_equal:now',
            'status'               => 'required|string|in:pending,approved,completed,cancelled',
            'complaint'            => 'required|string',
        ], [
            'appointment_datetime.after_or_equal' => 'Jadwal antrian tidak boleh menggunakan waktu yang sudah lewat.',
        ]);

        $this->operationalService->createQueue($validated);

        return response()->json(['success' => true]);
    }

    public function doneQueue(string $id): JsonResponse
    {
        $this->operationalService->markQueueAsDone($id);

        return response()->json(['success' => true]);
    }

    public function destroyQueue(string $id): JsonResponse
    {
        $this->operationalService->deleteQueue($id);

        return response()->json(['success' => true]);
    }

    public function history(): View
    {
        return view('admin.operational.history');
    }
}