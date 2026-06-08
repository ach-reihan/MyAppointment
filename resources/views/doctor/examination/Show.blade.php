<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pemeriksaan - {{ $patient['name'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/doctor.css'])
</head>

<body>

    @include('doctor.component.sidebar')

    <div class="main-content">
        @include('doctor.component.topbar')

        <div class="px-3">

            <div class="mb-3">
                <a href="{{ route('examination.Index') }}"
                    class="text-decoration-none text-muted fw-semibold d-inline-flex align-items-center hover-primary">
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
                                <span class="bg-light px-3 py-1 rounded-pill"><i class="bi bi-calendar3"></i>
                                    {{ $patient['dob'] }}</span>
                                <span class="bg-light px-3 py-1 rounded-pill"><i class="bi bi-telephone"></i>
                                    {{ $patient['phone'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-data="{
                activeTab: 'input',
                showSuccessModal: false,
            
                formData: {
                    diagnoses: '',
                    action: '',
                    prescription: '',
                    catatan_internal: ''
                },
            
                async submitPemeriksaan() {
                    try {
                        // PERBAIKAN: Gunakan helper route() dan $patient['id']
                        const url = '{{ route('examination.Store', $patient['id']) }}';
            
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.formData)
                        });
            
                        const result = await response.json();
                        if (response.ok && result.success) {
                            this.showSuccessModal = true;
                        } else {
                            alert('Gagal menyimpan rekam medis: ' + (result.message || 'Periksa kembali form Anda.'));
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Gagal menghubungi server.');
                    }
                }
            }">

                <ul class="nav nav-tabs border-bottom mb-4">
                    <li class="nav-item">
                        <a href="#" class="nav-link fw-semibold"
                            :class="{ 'active': activeTab === 'input', 'text-muted': activeTab !== 'input' }"
                            @click.prevent="activeTab = 'input'">
                            Input Pemeriksaan Baru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link fw-semibold text-muted"
                            :class="{ 'active': activeTab === 'history', 'text-muted': activeTab !== 'history' }"
                            @click.prevent="activeTab = 'history'">
                            Riwayat Rekam Medis
                        </a>
                    </li>
                </ul>

                <div class="position-relative">

                    {{-- section pemeriksaan --}}
                    <div x-show="activeTab === 'input'" x-transition.opacity.duration.300ms>

                        <form @submit.prevent="submitPemeriksaan()">
                            <div class="row g-4">
                                <div class="col-lg-8">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-body p-4">
                                            <h5 class="fw-bold mb-4">Detail Pemeriksaan</h5>

                                            <div class="mb-4">
                                                <label class="form-label text-muted small fw-semibold">Diagnosa
                                                    Medis</label>
                                                <textarea x-model="formData.diagnoses" required class="form-control custom-input p-3" rows="4"
                                                    placeholder="Tuliskan hasil diagnosa pasien di sini..."></textarea>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label text-muted small fw-semibold">Tindakan
                                                    Medis</label>
                                                <textarea x-model="formData.action" required class="form-control custom-input p-3" rows="4"
                                                    placeholder="Deskripsikan tindakan yang diberikan kepada pasien..."></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted small fw-semibold">
                                                    <i class="bi bi-capsule me-1"></i> Resep Dokter
                                                </label>
                                                <textarea x-model="formData.prescription" required class="form-control custom-input p-3" rows="4"
                                                    placeholder="Tuliskan resep obat yang diberikan kepada pasien..."></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-body p-4">
                                            <h5 class="fw-bold mb-4">Ringkasan Sesi</h5>
                                            <div class="d-flex justify-content-between mb-3 small">
                                                <span class="text-muted">Tanggal</span>
                                                <span
                                                    class="fw-semibold">{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3 small">
                                                <span class="text-muted">Waktu Mulai</span>
                                                <span
                                                    class="fw-semibold">{{ \Carbon\Carbon::now()->format('H:i') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3 small">
                                                <span class="text-muted">Dokter Pemeriksa</span>
                                                <span class="fw-semibold">{{ $doctorName }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-4 small">
                                                <span class="text-muted">Poliklinik</span>
                                                <span class="fw-semibold">Poli Sesuai Jadwal</span>
                                            </div>
                                            <div class="bg-light border p-3 rounded-3 mt-4">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <i class="bi bi-info-circle text-dark"></i>
                                                    <span class="fw-bold text-dark small">Catatan Internal</span>
                                                </div>
                                                <textarea x-model="formData.catatan_internal"
                                                    class="form-control bg-transparent border-0 p-0 text-muted small shadow-none"
                                                    style="font-style: italic; resize: none;" rows="3"
                                                    placeholder="Tambahkan catatan internal opsional di sini..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-primary floating-btn d-flex align-items-center gap-2 shadow-lg mt-4">
                                <i class="bi bi-save"></i> Simpan & Selesai Periksa
                            </button>
                        </form>
                    </div>

                    {{-- section riwayat pemeriksaan --}}
                    <div x-show="activeTab === 'history'" x-transition.opacity.duration.300ms style="display: none;">
                        @include('doctor.component.history')
                    </div>

                </div>

                <div x-show="showSuccessModal" x-transition.opacity style="display: none;">
                    <div class="modal-backdrop fade show" style="background-color: rgba(0,0,0,0.4);"></div>

                    <div class="modal fade show d-block" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-body p-5 text-center">

                                    <div class="mb-4 d-flex justify-content-center">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 80px; height: 80px;">
                                            <i class="bi bi-check-lg" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>

                                    <h4 class="fw-bold mb-2">Pemeriksaan Selesai!</h4>
                                    <p class="text-muted mb-4 small">
                                        Data rekam medis pasien telah berhasil disimpan ke dalam sistem. Antrean pasien
                                        ini akan ditandai sebagai "Selesai".
                                    </p>

                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('examination.Index') }}"
                                            class="btn btn-primary rounded-pill py-2 fw-semibold">
                                            Kembali ke Daftar Antrean
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
