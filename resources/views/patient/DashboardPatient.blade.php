<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal - Healthink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    @vite(['resources/css/patient.css'])
</head>
<body>

    @include('patient.component.sidebar')

    <main class="main-content">
        @include('patient.component.topbar')

        <div class="container-fluid p-5 p-md-5 ">
            <div class="mb-4">
                <h2 class="fw-bold mb-1">Halo, Budi!</h2>
                <p class="text-muted">Selamat datang kembali. Berikut adalah ringkasan kesehatan Anda hari ini.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4 card-upcoming overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-4 align-items-start">
                            <div class="icon-box icon-box-purple flex-shrink-0" style="width: 60px; height: 60px; border-radius: 15px;">
                                <i class="bi bi-calendar-check fs-3"></i>
                            </div>
                            <div>
                                <span class="badge badge-subtle-success rounded-pill px-3 py-1 mb-2">DISETUJUI</span>
                                <span class="text-muted small ms-2">Janji Temu Mendatang</span>
                                <h4 class="fw-bold mb-1 mt-1">Dr. Andi Wijaya, Sp.PD</h4>
                                <div class="text-primary fw-semibold small mb-3">Poli Penyakit Dalam</div>
                                
                                <div class="d-flex gap-4 text-muted small fw-medium">
                                    <span><i class="bi bi-calendar3 me-1"></i> 24 Okt 2023</span>
                                    <span><i class="bi bi-clock me-1"></i> 09:00 WIB</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-end d-flex flex-column gap-2">
                            <a href="#" class="text-decoration-none fw-semibold small text-primary">Lihat Detail Lokasi</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                {{-- <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <div class="icon-box icon-box-red"><i class="bi bi-heart-pulse"></i></div>
                            <div>
                                <div class="text-muted small">Detak Jantung</div>
                                <div class="fw-bold"><span class="fs-5">72</span> <span class="small fw-normal text-muted">BPM</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <div class="icon-box icon-box-blue"><i class="bi bi-droplet"></i></div>
                            <div>
                                <div class="text-muted small">Tekanan Darah</div>
                                <div class="fw-bold"><span class="fs-5">120/80</span> <span class="small fw-normal text-muted">mmHg</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <div class="icon-box icon-box-green"><i class="bi bi-activity"></i></div>
                            <div>
                                <div class="text-muted small">Indeks Massa Tubuh</div>
                                <div class="fw-bold"><span class="fs-5">22.4</span> <span class="small fw-normal text-muted">Normal</span></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Riwayat Pemeriksaan</h5>
                <a href="#" class="text-decoration-none fw-semibold text-primary">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-light rounded-3 text-center p-2 me-4" style="min-width: 70px;">
                        <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">SEP</div>
                        <div class="fw-bold fs-4 text-dark line-height-1">12</div>
                    </div>
                    
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Dr. Sarah Fauziah</h6>
                        <div class="text-muted small mb-2">Poli Umum • Klinik Pratama</div>
                        <div class="d-flex gap-2">
                            <span class="badge badge-subtle-secondary rounded-pill px-3 py-2 fw-normal"><i class="bi bi-clipboard2-pulse me-1"></i> Nasofaringitis Akut</span>
                            <span class="badge badge-subtle-primary rounded-pill px-3 py-2 fw-normal"><i class="bi bi-capsule me-1"></i> Paracetamol 500mg, Vitamin C</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3 text-muted">
                        <i class="bi bi-download cursor-pointer hover-primary"></i>
                        <i class="bi bi-three-dots-vertical cursor-pointer hover-primary"></i>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-light rounded-3 text-center p-2 me-4" style="min-width: 70px;">
                        <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">AGU</div>
                        <div class="fw-bold fs-4 text-dark line-height-1">28</div>
                    </div>
                    
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Dr. Bambang Sugiarto</h6>
                        <div class="text-muted small mb-2">Dokter Gigi • Poli Gigi</div>
                        <div class="d-flex gap-2">
                            <span class="badge badge-subtle-secondary rounded-pill px-3 py-2 fw-normal"><i class="bi bi-clipboard2-pulse me-1"></i> Pembersihan Karang Gigi</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3 text-muted">
                        <i class="bi bi-download cursor-pointer hover-primary"></i>
                        <i class="bi bi-three-dots-vertical cursor-pointer hover-primary"></i>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-light rounded-3 text-center p-2 me-4" style="min-width: 70px;">
                        <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">JUN</div>
                        <div class="fw-bold fs-4 text-dark line-height-1">05</div>
                    </div>
                    
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Dr. Andi Wijaya, Sp.PD</h6>
                        <div class="text-muted small mb-2">Poli Penyakit Dalam • Konsultasi Rutin</div>
                        <div class="d-flex gap-2">
                            <span class="badge badge-subtle-secondary rounded-pill px-3 py-2 fw-normal"><i class="bi bi-clipboard2-pulse me-1"></i> Hipertensi Stage 1</span>
                            <span class="badge badge-subtle-primary rounded-pill px-3 py-2 fw-normal"><i class="bi bi-capsule me-1"></i> Amlodipine 5mg</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3 text-muted">
                        <i class="bi bi-download cursor-pointer hover-primary"></i>
                        <i class="bi bi-three-dots-vertical cursor-pointer hover-primary"></i>
                    </div>
                </div>
            </div>
        </div>    

    </main>

    <button class="btn btn-primary rounded-pill fw-semibold fab-btn d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle"></i> Buat Janji
    </button>

</body>
</html>