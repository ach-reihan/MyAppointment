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
                        </div>
                        <div class="text-muted small fw-semibold mb-1">Sisa Antrean Hari Ini</div>
                        <h1 class="fw-bold mb-0 text-dark">{{ $sisaAntrean }}</h1>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-custom h-100 p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="icon-box icon-box-blue">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="text-muted small fw-semibold mb-1">Pasien Selesai Diperiksa</div>
                        <h1 class="fw-bold mb-0 text-dark">{{ $pasienSelesai }}</h1>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-custom card-blue h-100 p-4 position-relative overflow-hidden">
                        <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.1;">
                            <i class="bi bi-heart-pulse-fill" style="font-size: 8rem;"></i>
                        </div>

                        <h5 class="fw-bold mb-3 position-relative z-1">Pengingat Jadwal Pemeriksaan</h5>
                        <p class="mb-4 position-relative z-1 text-white-50" style="font-size: 0.9rem;">
                            Anda memiliki {{ $totalJadwal }} jadwal pemeriksaan hari ini.
                        </p>
                        <div class="mt-auto position-relative z-1">
                            <a href="{{ route('examination.Index') }}"
                                class="btn btn-light rounded-pill px-4 fw-semibold text-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Antrean Berikutnya</h5>
                    <a href="{{ route('examination.Index') }}" class="text-decoration-none small fw-semibold">
                        Lihat Semua Antrean <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="d-flex gap-3 overflow-x-auto pb-3 pt-1 px-1" style="scrollbar-width: thin;">

                    @forelse($patients as $patient)
                        @php
                            $targetRoute = match ($patient['status']) {
                                'Pending' => route('examination.Index'),
                                'Disetujui' => route('examination.Show', $patient['id']),
                                'Selesai' => route('examination.Detail', $patient['id']),
                                default => route('examination.Index'),
                            };

                            $badgeClass = match ($patient['status']) {
                                'Pending' => 'bg-warning bg-opacity-10 text-warning',
                                'Disetujui' => 'bg-primary bg-opacity-10 text-primary',
                                'Selesai' => 'bg-success bg-opacity-10 text-success',
                                'Batal' => 'bg-danger bg-opacity-10 text-danger',
                                default => 'bg-secondary bg-opacity-10 text-secondary',
                            };
                        @endphp

                        <a href="{{ $targetRoute }}" class="text-decoration-none text-dark"
                            style="min-width: 280px; max-width: 280px;">
                            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                                <div class="card-body p-4 d-flex flex-column">

                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px;">
                                            <i class="bi bi-person-fill text-secondary fs-5"></i>
                                        </div>
                                        <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2 fw-normal small">
                                            {{ $patient['status'] }}
                                        </span>
                                    </div>

                                    <h6 class="fw-bold mb-1 text-truncate">{{ $patient['name'] }}</h6>
                                    <div class="text-muted small mb-0 flex-grow-1"
                                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $patient['complaint'] }}
                                    </div>

                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-muted small py-3">Tidak ada antrean pasien saat ini.</div>
                    @endforelse

                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
