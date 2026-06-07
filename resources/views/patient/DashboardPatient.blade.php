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

    @include('patient.component.sidebar')

    <main class="main-content">
        @include('patient.component.topbar')

        <div class="container-fluid p-5 p-md-5 ">
            <div class="mb-4">
                <h2 class="fw-bold mb-1">Halo, <span>{{ $patient->name ?? 'Budi Santoso' }}</span></h2>
                <p class="text-muted">Selamat datang kembali. Berikut adalah ringkasan kesehatan Anda hari ini.</p>
            </div>

            @include('patient.component.appointmentcard')

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Riwayat Pemeriksaan</h5>
                <a href="{{ route('patient.MedicalHistory') }}"
                    class="text-decoration-none fw-semibold text-primary">Lihat Semua <i
                        class="bi bi-arrow-right"></i></a>
            </div>

            <div class="mt-4">
                <div class="mt-4">
                    @forelse($histories as $history)
                        @include('patient.component.history', ['history' => $history])
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

</body>

</html>