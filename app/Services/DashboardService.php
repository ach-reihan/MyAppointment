<?php

namespace App\Services;

class DashboardService
{
    /**
     * Get macro summary stats for the dashboard header cards.
     */
    public function getMacroStats(): array
    {
        return [
            [
                'label'   => 'Total Pasien',
                'value'   => '1.284',
                'badge'   => '+12%',
                'badge_type' => 'up',
                'icon'    => 'users',
                'color'   => 'blue',
            ],
            [
                'label'   => 'Total Dokter',
                'value'   => '48',
                'badge'   => 'Tetap',
                'badge_type' => 'neutral',
                'icon'    => 'doctor',
                'color'   => 'indigo',
            ],
            [
                'label'   => 'Janji Temu Hari Ini',
                'value'   => '156',
                'badge'   => '8 Menunggu',
                'badge_type' => 'warning',
                'icon'    => 'calendar',
                'color'   => 'amber',
            ],
            [
                'label'   => 'Poli Aktif',
                'value'   => '12',
                'badge'   => 'Full Ops',
                'badge_type' => 'success',
                'icon'    => 'clinic',
                'color'   => 'emerald',
            ],
        ];
    }

    /**
     * Get weekly patient visit data for the bar chart.
     */
    public function getWeeklyVisits(): array
    {
        return [
            ['day' => 'Sen', 'count' => 82,  'pct' => 68],
            ['day' => 'Sel', 'count' => 95,  'pct' => 79],
            ['day' => 'Rab', 'count' => 120, 'pct' => 100],
            ['day' => 'Kam', 'count' => 108, 'pct' => 90],
            ['day' => 'Jum', 'count' => 113, 'pct' => 94],
            ['day' => 'Sab', 'count' => 47,  'pct' => 39],
            ['day' => 'Min', 'count' => 20,  'pct' => 17],
        ];
    }

    /**
     * Get recent activity log items.
     */
    public function getRecentActivities(): array
    {
        return [
            [
                'type'    => 'selesai',
                'title'   => 'Janji Temu Selesai',
                'desc'    => 'Bpk. Adi Prasetyo di Poli Gigi',
                'time'    => '10:45 WIB',
                'color'   => 'emerald',
            ],
            [
                'type'    => 'masuk',
                'title'   => 'Pasien Masuk',
                'desc'    => 'Ibu Siti Aminah (Antrian A-24)',
                'time'    => '11:12 WIB',
                'color'   => 'blue',
            ],
            [
                'type'    => 'baru',
                'title'   => 'Pasien Baru Terdaftar',
                'desc'    => 'Bpk. Rizky Firmansyah',
                'time'    => '11:30 WIB',
                'color'   => 'indigo',
            ],
            [
                'type'    => 'reschedule',
                'title'   => 'Reschedule Janji Temu',
                'desc'    => 'Ny. Dewi Kusuma – Poli Umum',
                'time'    => '11:45 WIB',
                'color'   => 'amber',
            ],
        ];
    }
}