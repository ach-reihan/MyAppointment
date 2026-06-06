<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dr. My Appointment</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/doctor.css'])

    
</head>
<body>

    @include('doctor.component.sidebar')

    <main class="main-content">
        @include('doctor.component.topbar')

        <div class="container-fluid p-4 p-md-5">
            
            <div class="mb-4">
                <h2 class="fw-bold text-dark mb-1">Selamat Pagi, Dokter</h2>
                <p class="text-muted">Berikut adalah ringkasan antrean dan jadwal pemeriksaan Anda hari ini.</p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card card-custom h-100 p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="icon-box icon-box-blue">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2">+4 jam ini</span>
                        </div>
                        <div class="text-muted small fw-semibold mb-1">Sisa Kuota Antrean Hari Ini</div>
                        <h1 class="fw-bold mb-0 text-dark">12</h1>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-custom h-100 p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="icon-box icon-box-gray">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2">Selesai 70%</span>
                        </div>
                        <div class="text-muted small fw-semibold mb-1">Pasien Selesai Diperiksa</div>
                        <h1 class="fw-bold mb-0 text-dark">28</h1>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-custom card-blue h-100 p-4 position-relative overflow-hidden">
                        <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.1;">
                            <i class="bi bi-heart-pulse-fill" style="font-size: 8rem;"></i>
                        </div>
                        
                        <h5 class="fw-bold mb-3 position-relative z-1">Pengingat Jadwal Pemeriksaan</h5>
                        <p class="mb-4 position-relative z-1 text-white-50" style="font-size: 0.9rem;">
                            Anda memiliki 3 jadwal pemeriksaan hari ini.
                        </p>
                        <div class="mt-auto position-relative z-1">
                            <a href="{{ route('examination.Index') }}" class="btn btn-light rounded-pill px-4 fw-semibold text-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Jadwal Kerja Mingguan</h5>
                    <a href="#" class="text-decoration-none text-primary small fw-semibold">Lihat Semua Jadwal</a>
                </div>

                <div class="d-flex flex-nowrap gap-3 pb-3 horizontal-scroll">
                    
                    <div class="card border-0 shadow-sm rounded-4 flex-shrink-0" style="width: 220px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">Senin</span>
                                <i class="bi bi-calendar-check text-muted"></i>
                            </div>
                            <div class="mt-3">
                                <div class="text-muted small mb-1">Jam Praktik</div>
                                <div class="text-muted small mb-1">Kuota: 30 pasien</div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clock text-primary"></i>
                                    <span class="fw-bold fs-5 text-dark">08:00 - 15:00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 flex-shrink-0" style="width: 220px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">Selasa</span>
                                <i class="bi bi-calendar-check text-muted"></i>
                            </div>
                            <div class="mt-3">
                                <div class="text-muted small mb-1">Jam Praktik</div>
                                <div class="text-muted small mb-1">Kuota: 25 pasien</div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clock text-primary"></i>
                                    <span class="fw-bold fs-5 text-dark">09:00 - 14:00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 flex-shrink-0" style="width: 220px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">Rabu</span>
                                <i class="bi bi-calendar-check text-muted"></i>
                            </div>
                            <div class="mt-3">
                                <div class="text-muted small mb-1">Jam Praktik</div>
                                <div class="text-muted small mb-1">Kuota: 20 pasien</div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clock text-primary"></i>
                                    <span class="fw-bold fs-5 text-dark">13:00 - 18:00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 flex-shrink-0" style="width: 220px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">Kamis</span>
                                <i class="bi bi-calendar-check text-muted"></i>
                            </div>
                            <div class="mt-3">
                                <div class="text-muted small mb-1">Jam Praktik</div>
                                <div class="text-muted small mb-1">Kuota: 30 pasien</div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clock text-primary"></i>
                                    <span class="fw-bold fs-5 text-dark">08:00 - 15:00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 flex-shrink-0" style="width: 220px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">Jumat</span>
                                <i class="bi bi-calendar-check text-muted"></i>
                            </div>
                            <div class="mt-3">
                                <div class="text-muted small mb-1">Jam Praktik</div>
                                <div class="text-muted small mb-1">Kuota: 30 pasien</div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clock text-primary"></i>
                                    <span class="fw-bold fs-5 text-dark">08:00 - 11:30</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 flex-shrink-0 bg-light" style="width: 220px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">Sabtu</span>
                                <i class="bi bi-calendar-x text-muted"></i>
                            </div>
                            <div class="mt-3">
                                <div class="text-muted small mb-1">Status</div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold fs-5 text-muted">Hari Libur</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
                
            </div>    
            <!-- <div class="card card-custom p-0 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Antrean Pasien Hari Ini</h5>
                    <div class="d-flex gap-2 text-muted">
                        <button class="btn btn-sm btn-link text-muted"><i class="bi bi-filter fs-5"></i></button>
                        <button class="btn btn-sm btn-link text-muted"><i class="bi bi-three-dots-vertical fs-5"></i></button>
                    </div>
                </div>
                
                <div class="table-responsive px-4">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="border-bottom">
                            <tr>
                                <th scope="col" class="pb-3 text-uppercase">No. Antrean</th>
                                <th scope="col" class="pb-3 text-uppercase">Nama Pasien</th>
                                <th scope="col" class="pb-3 text-uppercase">Keluhan</th>
                                <th scope="col" class="pb-3 text-uppercase">Status</th>
                                <th scope="col" class="pb-3 text-uppercase text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="patient-number">001</span></td>
                                <td>
                                    <div class="fw-semibold text-dark">Helga Lathif M</div>
                                    <div class="text-muted small">BPJS Kesehatan</div>
                                </td>
                                <td class="text-muted">Sakit tenggorokan dan sulit<br>menelan</td>
                                <td><span class="badge rounded-pill badge-menunggu">Menunggu</span></td>
                                <td class="text-end">
                                    <button class="btn btn-primary btn-sm px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                                        <i class="bi bi-person-bounding-box"></i> Periksa Pasien
                                    </button>
                                </td>
                            </tr>
                            
                            <tr>
                                <td><span class="patient-number">002</span></td>
                                <td>
                                    <div class="fw-semibold text-dark">Budi Santoso</div>
                                    <div class="text-muted small">Asuransi Mandiri</div>
                                </td>
                                <td class="text-muted">Demam tinggi dan batuk</td>
                                <td><span class="badge rounded-pill badge-selesai">Selesai</span></td>
                                <td class="text-end">
                                    <button class="btn btn-link text-dark text-decoration-none btn-sm px-3 py-2 d-inline-flex align-items-center gap-2">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-top-0 px-4 py-4 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Menampilkan 4 dari 12 antrean hari ini</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light border text-dark rounded-circle" style="width:35px; height:35px; padding:0;"><i class="bi bi-chevron-left"></i></button>
                        <button class="btn btn-outline-light border text-dark rounded-circle" style="width:35px; height:35px; padding:0;"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
            </div>-->
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>