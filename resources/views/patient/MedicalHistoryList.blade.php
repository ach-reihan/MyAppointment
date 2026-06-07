<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Riwayat Medis - MyAppointment</title>
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
                <a href="{{ route('DashboardPatient') }}"
                    class="text-decoration-none text-muted fw-semibold d-inline-flex align-items-center hover-primary">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <h4 class="fw-bold mb-4 ms-2">Semua Riwayat Pemeriksaan</h4>

            <div>
                @forelse($histories as $history)
                    @include('patient.component.history', ['history' => $history])
                @empty
                    <div class="text-center text-muted py-5">
                        Belum ada riwayat pemeriksaan.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</body>

</html>
