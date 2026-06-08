<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Janji Temu - MyAppointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/patient.css'])
</head>

<body>

    @include('patient.component.sidebar')

    <main class="main-content">

        @include('patient.component.topbar')

        <div class="container-fluid p-4 p-md-4">
            <div class="d-flex justify-content-center">
                <div class="card border-0 shadow-sm rounded-4 w-100" style="max-width: 800px;">
                    <div class="card-body p-5">

                        <div class="mb-5">
                            <h4 class="fw-bold mb-2">Informasi Kunjungan</h4>
                            <p class="text-muted small">Silakan lengkapi formulir di bawah ini untuk mengatur pertemuan
                                dengan spesialis kami.</p>
                        </div>

                        <div x-data="{ 
                            showSuccessModal: false,
                            clinics: {{ json_encode($clinics) }},
                            selectedClinicId: '{{ old('poliklinik', '') }}',
                            selectedDoctorId: '{{ old('dokter', '') }}',
                            get filteredDoctors() {
                                if (!this.selectedClinicId) return [];
                                const clinic = this.clinics.find(c => c.id === this.selectedClinicId);
                                return clinic ? clinic.doctors : [];
                            }
                        }">

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 p-3 mb-4" role="alert">
                                    <ul class="mb-0 small ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('FormAppointment.store') }}" method="POST">
                                @csrf
                                <div class="row g-4 mb-4">
                                    <div>
                                        <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                            <i class="bi bi-hospital me-1"></i> Pilih Poliklinik
                                        </label>
                                        <select class="form-select custom-input py-3" name="poliklinik" x-model="selectedClinicId" @change="selectedDoctorId = ''">
                                            <option value="" disabled>Pilih Poliklinik</option>
                                            @foreach ($clinics as $clinic)
                                                <option value="{{ $clinic['id'] }}">{{ $clinic['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                            <i class="bi bi-person me-1"></i> Pilih Dokter
                                        </label>
                                        <select class="form-select custom-input py-3" name="dokter" x-model="selectedDoctorId" :disabled="!selectedClinicId">
                                            <option value="" disabled>Pilih Dokter</option>
                                            <template x-for="doctor in filteredDoctors" :key="doctor.id">
                                                <option :value="doctor.id" x-text="doctor.name"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                            <i class="bi bi-calendar3 me-1"></i> Tanggal Janji
                                        </label>
                                        <input type="date" class="form-control custom-input py-3" name="tanggal" value="{{ old('tanggal') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                            <i class="bi bi-clock me-1"></i> Jam Janji
                                        </label>
                                        <input type="time" class="form-control custom-input py-3" name="waktu" value="{{ old('waktu') }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                            <i class="bi bi-file-text me-1"></i> Keluhan Utama
                                        </label>
                                        <textarea class="form-control custom-input py-3" rows="4" name="keluhan"
                                            placeholder="Jelaskan secara singkat gejala atau keluhan Anda...">{{ old('keluhan') }}</textarea>
                                    </div>



                                    <button type="submit"
                                        class="btn btn-primary w-100 py-3 rounded-3 fw-bold mb-3 d-flex justify-content-center align-items-center gap-2">
                                        <i class="bi bi-send-fill"></i> Daftar Janji Temu Sekarang
                                    </button>
                                </div>
                            </form>

                            <div x-show="showSuccessModal" x-transition.opacity style="display: none;">
                                <div class="modal-backdrop fade show" style="background-color: rgba(0,0,0,0.5);"></div>

                                <div class="modal fade show d-block" tabindex="-1" aria-hidden="true"
                                    @click.self="showSuccessModal = false">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                                            <div class="bg-primary" style="height: 6px;"></div>

                                            <div class="modal-body p-5 text-center">
                                                <div class="mb-4 d-flex justify-content-center">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 80px;">
                                                        <i class="bi bi-calendar-check" style="font-size: 3.5rem;"></i>
                                                    </div>
                                                </div>

                                                <h4 class="fw-bold mb-2">Pendaftaran Berhasil!</h4>
                                                <p class="text-muted mb-4 small">
                                                    Janji temu Anda telah berhasil didaftarkan. Silakan datang ke klinik
                                                    15 menit sebelum waktu yang dijadwalkan untuk proses administrasi.
                                                </p>

                                                <div
                                                    class="bg-light rounded-3 p-3 mb-4 text-start small border border-light-subtle">
                                                    <div class="d-flex justify-content-between align-items-center ">
                                                        <span class="text-muted">Status:</span>
                                                        <span class="badge bg-warning text-dark">Menunggu
                                                            Konfirmasi</span>
                                                    </div>
                                                    <div class="text-center text-muted mt-2"
                                                        style="font-size: 0.75rem;">
                                                        Detail lengkap telah dikirimkan ke email Anda.
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-column gap-2">
                                                    <a href="{{ route('DashboardPatient') }}"
                                                        class="btn btn-primary rounded-pill py-2 fw-semibold">
                                                        Kembali ke Dashboard
                                                    </a>
                                                    <button type="button" @click="showSuccessModal = false"
                                                        class="btn btn-link text-decoration-none text-muted fw-semibold small">
                                                        Tutup
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
