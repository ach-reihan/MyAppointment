<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\DashboardService;
use Illuminate\View\View;

class DashboardController 
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(): View
    {
        return view('admin.dashboard', [
            'stats'      => $this->dashboardService->getMacroStats(),
            'weekly'     => $this->dashboardService->getWeeklyVisits(),
            'activities' => $this->dashboardService->getRecentActivities(),
        ]);
    }
}