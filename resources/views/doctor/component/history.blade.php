<div>
    @forelse($histories as $history)
        <div class="card border-0 shadow-sm rounded-4 mb-4 mx-3">
            <!-- Header Riwayat -->
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-start">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill mb-2 px-3 py-2">
                        <i class="bi bi-calendar3 me-1"></i> {{ $history['date'] }} • {{ $history['time'] }}
                    </span>
                    <h5 class="fw-bold mb-0">{{ $history['type'] }}</h5>
                </div>
                <div class="text-end text-muted small">
                    <div class="mb-1">Pasien: <span class="fw-bold text-dark">{{ $patient['name'] }}</span></div>
                    <div class="mb-1">Dokter Pemeriksa: <span class="fw-bold text-dark">{{ $history['doctor'] }}</span></div>
                    <div>Poliklinik: <span class="fw-bold text-dark">{{ $history['clinic'] }}</span></div>
                </div>
            </div>

            <div class="card-body p-4">
                <hr class="text-muted opacity-25 mt-0 mb-4">
                
                <div class="row g-4">
                    <!-- Kolom Kiri: Diagnosa, Tindakan, Resep -->
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">
                                <i class="bi bi-clipboard2-pulse me-1"></i> Diagnosa Medis
                            </h6>
                            <div class="bg-light p-3 rounded-3 small text-dark border border-light-subtle">
                                {{ $history['diagnosis'] }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">
                                <i class="bi bi-heart-pulse me-1"></i> Tindakan Medis
                            </h6>
                            <div class="bg-light p-3 rounded-3 small text-dark border border-light-subtle">
                                {{ $history['treatment'] }}
                            </div>
                        </div>

                         <div>
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">
                                <i class="bi bi-capsule me-1"></i> Resep Dokter
                            </h6>
                            <div class="bg-light p-3 rounded-3 small text-dark border border-light-subtle">
                                {{ $history['prescription'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Catatan -->
                    <div class="col-lg-4">
                        @if(isset($history['internal_note']) && $history['internal_note'])
                            <div class="bg-warning bg-opacity-10 border border-warning border-opacity-25 p-3 rounded-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-exclamation-triangle text-warning"></i>
                                    <span class="fw-bold text-dark small">Catatan Internal</span>
                                </div>
                                <p class="mb-0 text-muted small" style="font-style: italic;">
                                    {{ $history['internal_note'] }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-folder2-open fs-1"></i>
            <p class="mt-3">Belum ada riwayat rekam medis untuk pasien ini.</p>
        </div>
    @endforelse
</div>