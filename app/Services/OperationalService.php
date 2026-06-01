<?php

namespace App\Services;

class OperationalService
{
    /**
     * Data statistik antrian hari ini.
     */
    public function getQueueStats(): array
    {
        return [
            ['label' => 'Total Janji Temu', 'value' => '48', 'desc' => '+12% dari kemarin',     'color' => 'blue'],
            ['label' => 'Menunggu',         'value' => '12', 'desc' => 'Pasien di ruang tunggu', 'color' => 'amber'],
            ['label' => 'Dalam Proses',     'value' => '6',  'desc' => 'Sedang pemeriksaan',     'color' => 'indigo'],
            ['label' => 'Selesai',          'value' => '30', 'desc' => 'Pasien terlayani',       'color' => 'emerald'],
        ];
    }

    /**
     * Data tabel jadwal antrian hari ini.
     */
    public function getTodayQueue(): array
    {
        return [
            [
                'id' => '#PX-2023001', 'nama' => 'Budi Pratama', 'dokter' => 'Dr. Sarah Wijaya', 'poli' => 'Poli Umum',
                'waktu' => '14 Okt 2023, 08:00', 'status' => 'Menunggu', 'color' => 'amber', 'initial' => 'BP'
            ],
            [
                'id' => '#PX-2023005', 'nama' => 'Ani Nuraini',  'dokter' => 'Dr. Bambang S.',   'poli' => 'Poli Gigi',
                'waktu' => '14 Okt 2023, 09:45', 'status' => 'Proses',   'color' => 'blue',  'initial' => 'AN'
            ],
            [
                'id' => '#PX-2023012', 'nama' => 'Dedi Kusuma',  'dokter' => 'Dr. Sarah Wijaya', 'poli' => 'Poli Umum',
                'waktu' => '14 Okt 2023, 08:15', 'status' => 'Selesai',  'color' => 'emerald','initial' => 'DK'
            ],
            [
                'id' => '#PX-2023018', 'nama' => 'Siti Laila',   'dokter' => 'Dr. Bambang S.',   'poli' => 'Poli Gigi',
                'waktu' => '14 Okt 2023, 10:30', 'status' => 'Menunggu', 'color' => 'amber', 'initial' => 'SL'
            ],
        ];
    }

    /**
     * Data mock riwayat medis untuk ditampilkan di sidebar pop-up.
     */
    public function getMedicalHistory(): array
    {
        return [
            [
                'tanggal'  => '02 Sept 2023',
                'dokter'   => 'Dr. Sarah Wijaya',
                'diagnosa' => 'Faringitis Akut (Radang Tenggorokan)',
                'tindakan' => 'Pemberian antipiretik dan edukasi istirahat cukup.',
                'resep'    => ['Amoxicillin 500mg (3x1)', 'Paracetamol 500mg (3x1)', 'Vitamin C 500mg (1x1)']
            ],
            [
                'tanggal'  => '15 Jun 2023',
                'dokter'   => 'Dr. Bambang S.',
                'diagnosa' => 'Karies Dentis (Gigi Berlubang)',
                'tindakan' => 'Penambalan gigi sementara.',
                'resep'    => ['Asam Mefenamat 500mg (PRN)']
            ],
            [
                'tanggal'  => '02 Jan 2023',
                'dokter'   => 'Dr. Sarah Wijaya',
                'diagnosa' => 'Check-up Rutin (Sehat)',
                'tindakan' => 'Pemeriksaan fisik menyeluruh, tensi normal.',
                'resep'    => []
            ],
        ];
    }
}