<?php

namespace App\Services;

class MasterDataService
{
    public function getUsers(): array
    {
        return [
            [
                'id'         => 'USR-001',
                'username'   => 'admin_sarah',
                'role'       => 'Admin',
                'created_at' => '12 Okt 2023, 14:20',
            ],
            [
                'id'         => 'USR-002',
                'username'   => 'dr_andi_w',
                'role'       => 'Dokter',
                'created_at' => '15 Okt 2023, 09:10',
            ],
            [
                'id'         => 'USR-003',
                'username'   => 'budi_santoso',
                'role'       => 'Pasien',
                'created_at' => '20 Okt 2023, 11:45',
            ],
            [
                'id'         => 'USR-004',
                'username'   => 'dr_siska_l',
                'role'       => 'Dokter',
                'created_at' => '22 Okt 2023, 08:30',
            ],
            [
                'id'         => 'USR-005',
                'username'   => 'dewi_kusuma',
                'role'       => 'Pasien',
                'created_at' => '25 Okt 2023, 13:15',
            ],
        ];
    }

    public function getDoctors(): array
    {
        return [
            [
                'id'           => 'DR-001',
                'nama'         => 'dr. Andi Wijaya, Sp.PD',
                'spesialisasi' => 'Penyakit Dalam',
                'poli'         => ['Poli Umum', 'VIP'],
            ],
            [
                'id'           => 'DR-002',
                'nama'         => 'dr. Siska Larasati, Sp.A',
                'spesialisasi' => 'Spesialis Anak',
                'poli'         => ['Poli Anak'],
            ],
        ];
    }

    public function getPatients(): array
    {
        return [
            [
                'id'         => 'PS-10234',
                'nama'       => 'Budi Santoso',
                'no_telepon' => '0812-3456-7890',
                'tgl_lahir'  => '12 Mei 1985',
                'alamat'     => 'Jl. Mawar No. 45, Jakarta',
            ],
            [
                'id'         => 'PS-10235',
                'nama'       => 'Siti Aminah',
                'no_telepon' => '0853-9988-7766',
                'tgl_lahir'  => '24 Agustus 1990',
                'alamat'     => 'Jl. Melati No. 12, Bandung',
            ],
        ];
    }

    public function getPolyclinics(): array
    {
        return [
            [
                'id'            => 'POL-001',
                'nama'          => 'Poli Umum',
                'deskripsi'     => 'Layanan pemeriksaan kesehatan menyeluruh dan konsultasi awal medis untuk segala keluhan...',
                'jumlah_dokter' => 12,
                'status'        => 'AKTIF',
                'icon'          => 'umum',
                'border_color'  => 'border-blue-600'
            ],
            [
                'id'            => 'POL-002',
                'nama'          => 'Poli Anak',
                'deskripsi'     => 'Pusat layanan kesehatan anak terintegrasi, mulai dari imunisasi, tumbuh kembang, hingga...',
                'jumlah_dokter' => 5,
                'status'        => 'AKTIF',
                'icon'          => 'anak',
                'border_color'  => 'border-slate-800'
            ],
        ];
    }
}