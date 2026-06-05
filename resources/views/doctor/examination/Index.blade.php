<?php
    $doctorName = "Dr. Healthink";
    $patientName = "Helga Lathif M";
    $patientAge = "35 Tahun";
    $patientDob = "12-05-1988";
    $patientPhone = "0812-3456-7890";
    $startTime = "14:05 WIB";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pemeriksaan - <?= $doctorName ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/doctor.css'])


</head>
<body>

    @include('doctor.component.sidebar')

    <div class="main-content">
        @include('doctor.component.topbar')
        
        <div class="px-3 py-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Antrean Pasien Hari Ini</h5>
                    <div class="d-flex gap-2 text-muted">
                        <button class="btn btn-sm btn-link text-muted"><i class="bi bi-filter fs-5"></i></button>
                        <button class="btn btn-sm btn-link text-muted"><i class="bi bi-three-dots-vertical fs-5"></i></button>
                    </div>
                </div>
                
                <div class="table-responsive px-4">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="border-bottom text-muted small">
                            <tr>
                                <th scope="col" class="pb-3 text-uppercase fw-semibold">No. Antrean</th>
                                <th scope="col" class="pb-3 text-uppercase fw-semibold">Nama Pasien</th>
                                <th scope="col" class="pb-3 text-uppercase fw-semibold">Keluhan</th>
                                <th scope="col" class="pb-3 text-uppercase fw-semibold">Status</th>
                                <th scope="col" class="pb-3 text-uppercase fw-semibold text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-bottom">
                                <td class="py-3"><span class="patient-number">001</span></td>
                                <td>
                                    <div class="fw-bold text-dark">Helga Lathif M</div>
                                    <div class="text-muted small">BPJS Kesehatan</div>
                                </td>
                                <td class="text-muted">Sakit tenggorokan dan sulit<br>menelan</td>
                                <td><span class="badge rounded-pill badge-menunggu px-3 py-2">Menunggu</span></td>
                                <td class="text-end">
                                    <a href="{{ route('examination.Show', ['id' => '001']) }}" class="btn btn-primary btn-sm px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                                        <i class="bi bi-person-bounding-box"></i> Periksa Pasien
                                    </a>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="py-3"><span class="patient-number">002</span></td>
                                <td>
                                    <div class="fw-bold text-dark">Budi Santoso</div>
                                    <div class="text-muted small">Asuransi Mandiri</div>
                                </td>
                                <td class="text-muted">Demam tinggi dan batuk</td>
                                <td><span class="badge rounded-pill badge-selesai px-3 py-2">Selesai</span></td>
                                <td class="text-end">
                                    <a href="{{ route('examination.Detail', ['id' => '001']) }}" class="btn btn-link text-dark text-decoration-none btn-sm px-3 py-2 d-inline-flex align-items-center gap-2">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-top-0 px-4 py-4 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Menampilkan 2 dari 12 antrean hari ini</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary border rounded-circle d-flex align-items-center justify-content-center" style="width:35px; height:35px;"><i class="bi bi-chevron-left"></i></button>
                        <button class="btn btn-outline-secondary border rounded-circle d-flex align-items-center justify-content-center" style="width:35px; height:35px;"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>