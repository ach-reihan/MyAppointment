<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\OperationalService;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Clinic;
use Illuminate\View\View;

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

    public function history(): View
    {
        return view('admin.operational.history');
    }
}