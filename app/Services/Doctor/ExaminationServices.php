<?php

namespace App\Services\Doctor;

class ExaminationServices
{
    //mockdata list antrian pasien hari ini
    public function getTodayQueue()
    {
        return [
            [
                'id' => '001',
                'queue_number' => '001',
                'phone' => '081234567890',
                'dob' => '1990-05-15',
                'name' => 'Helga Lathif M',
                'insurance' => 'BPJS Kesehatan',
                'complaint' => 'Sakit tenggorokan dan sulit menelan',
                'status' => 'Menunggu',
            ],
            [
                'id' => '002',
                'queue_number' => '002',
                'phone' => '081234567891',
                'dob' => '1985-06-12',
                'name' => 'Budi Santoso',
                'insurance' => 'Asuransi Mandiri',
                'complaint' => 'Demam tinggi dan batuk',
                'status' => 'Selesai',
            ],
            [
                'id' => '003',
                'queue_number' => '003',
                'phone' => '081234567892',
                'dob' => '1992-01-20',
                'name' => 'Siti Aminah',
                'insurance' => 'BPJS Kesehatan',
                'complaint' => 'Nyeri perut dan mual',
                'status' => 'Menunggu',
            ],
            [
                'id' => '004',
                'queue_number' => '004',
                'phone' => '081234567893',
                'dob' => '1988-11-05',
                'name' => 'Andi Wijaya',
                'insurance' => 'Asuransi Sehatku',
                'complaint' => 'Pusing dan lemas',
                'status' => 'Selesai',
            ],  
        ];
    }

    public function getMedicalHistory($patientId)
    {
        // Mock data for patient 001 (Helga)
        if ($patientId === '001') {
            return [
                [
                    'id' => 'rec_101',
                    'date' => '15 Oktober 2023',
                    'time' => '14:05 WIB',
                    'type' => 'Pemeriksaan Rutin',
                    'doctor' => 'Dr. Anisa Rahmawati',
                    'clinic' => 'Umum',
                    'diagnosis' => 'Pasien mengeluhkan pusing kronis dan kelelahan. Tekanan darah menunjukkan angka 140/90 (Hipertensi Tahap 1).',
                    'treatment' => 'Melakukan cek tekanan darah menyeluruh. Memberikan edukasi terkait pola tidur yang baik dan manajemen stres untuk menurunkan tekanan darah secara alami.',
                    'prescription' => 'Amlodipine 5mg (1x sehari), B-Complex (1x sehari)', // Simplified for the text box
                    'internal_note' => 'Pasien memiliki riwayat maag, hindari pemberian obat yang mengiritasi lambung jika memungkinkan.'
                ]
            ];
        }

        // Mock data for patient 002 (Budi)
        if ($patientId === '002') {
             return [
                [
                    'id' => 'rec_102',
                    'date' => '22 Agustus 2023',
                    'time' => '09:30 WIB',
                    'type' => 'Keluhan Pencernaan',
                    'doctor' => 'Dr. Budi Santoso',
                    'clinic' => 'Penyakit Dalam',
                    'diagnosis' => 'Gastritis Akut.',
                    'treatment' => 'Pemeriksaan fisik abdomen, saran diet lunak.',
                    'prescription' => 'Antasida Syrup (3x sehari), Omeprazole (1x sehari)',
                    'internal_note' => 'Pasien perokok aktif, sarankan untuk mengurangi konsumsi nikotin.'
                ]
            ];
        }

            // Mock data for patient 003 (Siti)
        if ($patientId === '003') {
            return [
                [
                    'id' => 'rec_103',
                    'date' => '10 September 2023',
                    'time' => '11:15 WIB',
                    'type' => 'Pemeriksaan Umum',
                    'doctor' => 'Dr. Siti Aminah',
                    'clinic' => 'Umum',
                    'diagnosis' => 'Infeksi Saluran Kemih (ISK).',
                    'treatment' => 'Pemeriksaan urin lengkap, edukasi kebersihan area genital.',
                    'prescription' => 'Ciprofloxacin 500mg (2x sehari selama 7 hari)',
                    'internal_note' => 'Pasien memiliki riwayat alergi terhadap sulfa, pastikan untuk memantau reaksi alergi.'
                ]
            ];
        }

        // Mock data for patient 004 (Andi)
        if ($patientId === '004') {
            return [
                [
                    'id' => 'rec_104',
                    'date' => '05 Juli 2023',
                    'time' => '16:45 WIB',
                    'type' => 'Pemeriksaan Kesehatan',
                    'doctor' => 'Dr. Andi Wijaya',
                    'clinic' => 'Umum',
                    'diagnosis' => 'Pasien mengeluhkan nyeri dada ringan dan sesak napas saat beraktivitas. EKG menunjukkan hasil normal, kemungkinan angina ringan.',
                    'treatment' => 'Pemeriksaan lanjutan dengan tes stres jantung, edukasi terkait manajemen stres dan pola hidup sehat.',
                    'prescription' => 'Nitroglycerin Sublingual (sesuai kebutuhan), Aspirin 81mg (1x sehari)',
                    'internal_note' => 'Pasien memiliki riwayat hipertensi, pastikan untuk memantau tekanan darah secara rutin.'
                ]
            ];
        }
    }
    
    // Helper to get patient details for the profile header
    public function getPatientDetails($patientId) {
        $patients = $this->getTodayQueue();
        foreach ($patients as $p) {
            if ($p['id'] === $patientId) return $p;
        }
        return null;
    }
}
