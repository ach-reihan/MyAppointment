<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Pemeriksaan - {{ $patient['name'] }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        @vite(['resources/css/doctor.css'])
    </head>

<body>
    @include('doctor.component.sidebar')
    
    <div class="main-content">
        @include('doctor.component.topbar')
        
        <div class="px-3">
            <div class="mb-3">
                <a href="{{ route('examination.Index') }}" class="text-decoration-none text-muted fw-semibold d-inline-flex align-items-center hover-primary">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Antrean
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 d-flex justify-content-start gap-4">
                    <div class="d-flex align-items-center gap-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-person fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-2">{{ $patient['name'] }}</h4>
                            <div class="d-flex gap-3 text-muted small">
                                <span class="bg-light px-3 py-1 rounded-pill">
                                    <i class="bi bi-calendar3"></i> {{ $patient['dob'] }}
                                </span>
                                <span class="bg-light px-3 py-1 rounded-pill">
                                    <i class="bi bi-telephone"></i> {{ $patient['phone'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-4 ms-2">Riwayat Rekam Medis Pasien</h5>

            @include('doctor.component.history')

        </div>
    </div>
</body>
</html>