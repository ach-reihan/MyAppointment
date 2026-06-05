<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Janji Temu - Healthink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
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
                            <p class="text-muted small">Silakan lengkapi formulir di bawah ini untuk mengatur pertemuan dengan spesialis kami.</p>
                        </div>

                        <form action="" method="POST">
                            <div class="row g-4 mb-4">
                                <div>
                                    <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                        <i class="bi bi-hospital me-1"></i> Pilih Poliklinik
                                    </label>
                                    <select class="form-select custom-input py-3" name="poliklinik">
                                        <option selected disabled>Pilih Poliklinik</option>
                                        <option value="umum">Poli Umum</option>
                                        <option value="gigi">Poli Gigi</option>
                                        <option value="penyakit_dalam">Poli Penyakit Dalam</option>
                                    </select>
                                </div>    
                                {{-- <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                        <i class="bi bi-person-badge me-1"></i> Pilih Dokter
                                    </label>
                                    <select class="form-select custom-input py-3" name="dokter">
                                        <option selected disabled>Pilih Dokter</option>
                                        <option value="1">Dr. Andi Wijaya, Sp.PD</option>
                                        <option value="2">Dr. Sarah Fauziah</option>
                                    </select>
                                </div> --}}

                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                        <i class="bi bi-calendar3 me-1"></i> Tanggal Janji
                                    </label>
                                    <input type="date" class="form-control custom-input py-3" name="tanggal">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                        <i class="bi bi-clock me-1"></i> Jam Janji
                                    </label>
                                    <input type="time" class="form-control custom-input py-3" name="waktu">
                                </div>

                                <div class="col-12">
                                    <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                        <i class="bi bi-file-text me-1"></i> Keluhan Utama
                                    </label>
                                    <textarea class="form-control custom-input py-3" rows="4" name="keluhan" placeholder="Jelaskan secara singkat gejala atau keluhan Anda..."></textarea>
                                </div>

                                <div class="col-12">    
                                    <label class="form-label text-muted fw-bold text-uppercase form-label-custom">
                                        <i class="bi bi-card-list me-1"></i> Catatan Internal
                                    </label>
                                    <textarea class="form-control custom-input py-3" rows="4" name="riwayat_penyakit" placeholder="Jelaskan riwayat penyakit Anda..."></textarea>
                                </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold mb-3 d-flex justify-content-center align-items-center gap-2">
                                <i class="bi bi-send-fill"></i> Daftar Janji Temu Sekarang
                            </button>
                            
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>