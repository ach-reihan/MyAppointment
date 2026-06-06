<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\MasterDataService;
use Illuminate\View\View;

class MasterDataController
{
    public function __construct(
        protected MasterDataService $masterDataService
    ) {}

    public function users(): View
    {
        return view('admin.master-data.users', [
            'users' => $this->masterDataService->getUsers(),
        ]);
    }

    public function doctors(): View
    {
        return view('admin.master-data.doctors', [
            'doctors' => $this->masterDataService->getDoctors()
        ]);
    }

    public function patients(): View
    {
        return view('admin.master-data.patients', [
            'patients' => $this->masterDataService->getPatients()
        ]);
    }

    public function polyclinics(): View
    {
        return view('admin.master-data.polyclinics', [
            'polyclinics' => $this->masterDataService->getPolyclinics()
        ]);
    }
}