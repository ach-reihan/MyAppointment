<?php

namespace App\Http\Controllers;

use App\Services\OperationalService;
use Illuminate\View\View;

class OperationalController 
{
    public function __construct(
        protected OperationalService $operationalService
    ) {}

    public function queue(): View
    {
        return view('admin.operational.queue', [
            'stats'   => $this->operationalService->getQueueStats(),
            'queues'  => $this->operationalService->getTodayQueue(),
            'history' => $this->operationalService->getMedicalHistory(),
        ]);
    }

    public function history(): View
    {
        return view('admin.operational.history');
    }
}