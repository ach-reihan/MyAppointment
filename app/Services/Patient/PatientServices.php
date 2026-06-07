<?php

namespace App\Services\Patient;

class PatientServices
{
    /**
     * Mengambil daftar poliklinik yang tersedia (Mock Data)
     */
    public function getAllClinics()
    {
        return [
            [
                'id' => 'umum',
                'name' => 'Poli Umum'
            ],
            [
                'id' => 'gigi',
                'name' => 'Poli Gigi'
            ],
            [
                'id' => 'penyakit_dalam',
                'name' => 'Poli Penyakit Dalam'
            ],
        ];
    }
    public function getAppointmentDetail($id)
    {
        if ($id === 'APT-001') {
            return [
                'id' => 'APT-001',
                'status' => 'DISETUJUI',
                'doctor_name' => 'Dr. Andi Wijaya, Sp.PD',
                'clinic' => 'Poli Penyakit Dalam',
                'date' => '24 Oktober 2023',
                'time' => '09:00 WIB',
                'complaint' => 'Sering merasa pusing, lelah berkepanjangan, dan detak jantung kadang tidak beraturan saat malam hari.',
                'internal_note' => 'Pernah dirawat karena gejala tifus 2 tahun lalu. Tidak memiliki riwayat alergi obat.',
                'created_at' => '20 Oktober 2023, 10:15 WIB'
            ];
        }

        return null;
    }

    
    public function getPatientHistory()
    {
        return [
            [
                'id' => 'REC-001',
                'date' => '12 September 2023',
                'time' => '10:30 WIB',
                'type' => 'Nasofaringitis Akut',
                'doctor' => 'Dr. Sarah Fauziah',
                'clinic' => 'Poli Umum',
                'diagnosis' => 'Peradangan pada mukosa hidung dan tenggorokan (Faring).',
                'treatment' => 'Pemberian obat pereda gejala, anjuran istirahat cukup dan perbanyak minum air putih.',
                'prescription' => 'Paracetamol 500mg (3x sehari), Vitamin C (1x sehari)',
                'internal_note' => null // Dibuat null agar kotak peringatan kuning tidak muncul di sisi pasien
            ],
            [
                'id' => 'REC-002',
                'date' => '05 Juni 2023',
                'time' => '09:00 WIB',
                'type' => 'Konsultasi Rutin',
                'doctor' => 'Dr. Andi Wijaya, Sp.PD',
                'clinic' => 'Poli Penyakit Dalam',
                'diagnosis' => 'Hipertensi Stage 1. Tekanan darah 140/90 mmHg.',
                'treatment' => 'Edukasi diet rendah garam, olahraga ringan 30 menit sehari.',
                'prescription' => 'Amlodipine 5mg (1x sehari sesudah makan)',
                'internal_note' => null
            ]
        ];
    }

    public function getHistoryDetail($id)
    {
        $histories = $this->getPatientHistory();
        
        foreach ($histories as $history) {
            if ($history['id'] === $id) {
                return $history;
            }
        }
        return null;
    }

    public function getPatientProfile()
    {
        return [
            'name' => 'Budi Santoso',
            'id' => 'HT-88219'
        ];
    }

    public function getUpcomingAppointments()
    {
        return [
            [
                'id' => 'APT-001',
                'doctor_name' => 'Dr. Andi Wijaya, Sp.PD',
                'clinic' => 'Poli Penyakit Dalam',
                'date' => '24 Okt 2023',
                'time' => '09:00 WIB',
                'status' => 'DISETUJUI',
                'status_color' => 'success' // Kita gunakan ini untuk warna badge di Blade nanti
            ],
            [
                'id' => 'APT-002',
                'doctor_name' => 'Dr. Sarah Fauziah',
                'clinic' => 'Poli Umum',
                'date' => '28 Okt 2023',
                'time' => '10:30 WIB',
                'status' => 'MENUNGGU',
                'status_color' => 'warning'
            ]
        ];
    }
}