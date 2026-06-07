<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Riwayat Medis - MyAppointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/patient.css'])
</head>
<body>

    @include('patient.component.sidebar')

    <div class="main-content">
        
        @include('patient.component.topbar')

        <div class="px-3">
            <div class="mb-4">
                <a href="{{ route('patient.MedicalHistory') }}" class="text-decoration-none text-muted fw-semibold d-inline-flex align-items-center hover-primary">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Riwayat
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4 mx-3">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill mb-2 px-3 py-2">
                            <i class="bi bi-calendar3 me-1"></i> {{ $history['date'] }} • {{ $history['time'] }}
                        </span>
                        <h5 class="fw-bold mb-0">{{ $history['type'] }}</h5>
                    </div>
                    <div class="text-end text-muted small">
                        <div class="mb-1">Dokter Pemeriksa: <span class="fw-bold text-dark">{{ $history['doctor'] }}</span></div>
                        <div>Poliklinik: <span class="fw-bold text-dark">{{ $history['clinic'] }}</span></div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <hr class="text-muted opacity-25 mt-0 mb-4">
                    
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="mb-4">
                                <h6 class="text-muted small fw-bold text-uppercase mb-2"><i class="bi bi-clipboard2-pulse me-1"></i> Diagnosa Medis</h6>
                                <div class="bg-light p-3 rounded-3 small text-dark border border-light-subtle">{{ $history['diagnosis'] }}</div>
                            </div>
                            <div class="mb-4">
                                <h6 class="text-muted small fw-bold text-uppercase mb-2"><i class="bi bi-heart-pulse me-1"></i> Tindakan Medis</h6>
                                <div class="bg-light p-3 rounded-3 small text-dark border border-light-subtle">{{ $history['treatment'] }}</div>
                            </div>
                            <div>
                                <h6 class="text-muted small fw-bold text-uppercase mb-2"><i class="bi bi-capsule me-1"></i> Resep Dokter</h6>
                                <div class="bg-light p-3 rounded-3 small text-dark border border-light-subtle">{{ $history['prescription'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> 
</body>
</html>