<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
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