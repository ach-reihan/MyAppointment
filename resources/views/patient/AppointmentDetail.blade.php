{{-- page detail janji temu --}}
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Janji Temu - MyAppointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/patient.css'])
    </head>
<body>
    
    @include('patient.components.sidebar')

    <div class="main-content">
        @include('patient.components.topbar')
        
        <div class="px-3">
            <div class="mb-4">
                <a href="{{ route('DashboardPatient') }}" class="text-decoration-none text-muted fw-semibold d-inline-flex align-items-center hover-primary">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>

            {{-- card detail janji temu --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill mb-2 px-3 py-2 fw-semibold">
                            {{ $appointment['status'] }}
                        </span>
                        <h5 class="fw-bold mb-0">Detail Janji Temu</h5>
                        <div class="text-muted small mt-1">ID Tiket: {{ $appointment['id'] }}</div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <hr class="text-muted opacity-25 mt-0 mb-4">

                    <div class="row g-4">
                        <div class="col-12 mb-2">
                            <div class="d-flex flex-wrap gap-5 bg-light p-3 rounded-3 border border-light-subtle">
                                <div>
                                    <div class="text-muted small mb-1"><i class="bi bi-calendar3 me-1"></i> Tanggal</div>
                                    <div class="fw-bold text-dark">{{ $appointment['date'] }}</div>
                                </div>
                                <div>
                                    <div class="text-muted small mb-1"><i class="bi bi-clock me-1"></i> Waktu</div>
                                    <div class="fw-bold text-dark">{{ $appointment['time'] }}</div>
                                </div>
                                <div>
                                    <div class="text-muted small mb-1"><i class="bi bi-hospital me-1"></i> Poliklinik</div>
                                    <div class="fw-bold text-dark">{{ $appointment['clinic'] }}</div>
                                </div>
                                <div>
                                    <div class="text-muted small mb-1"><i class="bi bi-person-badge me-1"></i> Dokter Pemeriksa</div>
                                    <div class="fw-bold text-dark">{{ $appointment['doctor_name'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">
                                <i class="bi bi-file-text me-1"></i> Keluhan Utama
                            </h6>
                            <div class="bg-light p-3 rounded-3 small text-dark border border-light-subtle h-100">
                                {{ $appointment['complaint'] }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-muted small mt-4 text-end text-xs">
                        Dibuat pada: {{ $appointment['created_at'] }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>