<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Services\Admin\DashboardService;
use App\Events\DashboardUpdated;

class AppointmentObserver
{
    // Fungsi ini dipanggil otomatis setiap kali ada data Appointment yang disimpan (dibuat/diubah)
    public function saved(Appointment $appointment): void
    {
        $this->triggerDashboardUpdate();
    }

    // Fungsi ini dipanggil otomatis setiap data Appointment dihapus
    public function deleted(Appointment $appointment): void
    {
        $this->triggerDashboardUpdate();
    }

    private function triggerDashboardUpdate(): void
    {
        // Ambil data terbaru dari service
        $service = app(DashboardService::class);
        
        // Tembakkan event Websocket ke Frontend
        broadcast(new DashboardUpdated(
            $service->getMacroStats(),
            $service->getWeeklyVisits(),
            $service->getRecentActivities()
        ));
    }
}