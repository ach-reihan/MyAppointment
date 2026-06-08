<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal - MyAppointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/patient.css'])
</head>

<body>

    @include('patient.components.sidebar')

    <main class="main-content">
        @include('patient.components.topbar')

        <div class="container-fluid p-5 p-md-5 ">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 p-3 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Halo, <span>{{ $patient->name ?? 'Budi Santoso' }}</span></h2>
                <p class="text-muted">Selamat datang kembali. Berikut adalah ringkasan kesehatan Anda hari ini.</p>
            </div>

            {{-- card janji temu yang di dashboard  --}}
            @forelse($upcomingAppointments as $appointment)
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
                    style="border-left: 6px solid {{ $appointment['status'] === 'MENUNGGU' ? '#ffc107' : ($appointment['status'] === 'DIBATALKAN' ? '#dc3545' : '#0d6efd') }} !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            
                            <div class="d-flex gap-4 align-items-start">
                                <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0 appointment-icon-box">
                                    <i class="bi bi-calendar-check fs-3"></i>
                                </div>
                                <div>
                                    <span class="badge bg-{{ $appointment['status_color'] }} bg-opacity-10 text-{{ $appointment['status_color'] }} rounded-pill px-3 py-1 mb-2 fw-semibold">
                                        {{ $appointment['status'] }}
                                    </span>
                                    <span class="text-muted small ms-2">Janji Temu Mendatang</span>
                                    
                                    <h4 class="fw-bold mb-1 mt-1">{{ $appointment['doctor_name'] }}</h4>
                                    <div class="text-primary fw-semibold small mb-3">{{ $appointment['clinic'] }}</div>
                                    
                                    <div class="d-flex gap-4 text-muted small fw-medium">
                                        <span><i class="bi bi-calendar3 me-1"></i> {{ $appointment['date'] }}</span>
                                        <span><i class="bi bi-clock me-1"></i> {{ $appointment['time'] }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end d-flex flex-column gap-2">
                                {{-- @if($appointment['status'] === 'DISETUJUI')
                                    <button class="btn btn-primary fw-semibold rounded-3 px-4 py-2">
                                        <i class="bi bi-qr-code-scan me-2"></i> Check-in QR
                                    </button>
                                @endif --}}
                                
                                <a href="{{ route('patient.appointment.detail', $appointment['id']) }}" class="text-decoration-none fw-semibold small text-primary">
                                    Lihat Detail Janji
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center bg-white p-5 rounded-4 shadow-sm mb-5 border-0 text-muted">
                    <i class="bi bi-calendar-x fs-1"></i>
                    <p class="mt-3 mb-0">Belum ada jadwal janji temu mendatang.</p>
                </div>
            @endforelse

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Riwayat Pemeriksaan</h5>
                <a href="{{ route('patient.MedicalHistory') }}"
                    class="text-decoration-none fw-semibold text-primary">Lihat Semua <i
                        class="bi bi-arrow-right"></i></a>
            </div>

            <div class="mt-4">
                <div class="mt-4">
                    @forelse($histories as $history)
                        @include('patient.components.history', ['history' => $history])
                    @empty
                        <div class="text-center py-4 text-muted">
                            Belum ada riwayat pemeriksaan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </main>

    <a href="{{ route('FormAppointment') }}"
        class="btn btn-primary rounded-pill fw-semibold fab-btn d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle"></i> Buat Janji
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>