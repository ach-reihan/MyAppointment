@php
    $user = auth()->user();
    $doctor = $user ? $user->doctor : \App\Models\Doctor::with('clinics')->first();
    
    $doctorName = $doctor ? $doctor->display_name : 'Nama Dokter Tidak Ditemukan';
    
    $polyclinic = 'Poli Umum';
    if ($doctor && $doctor->clinics->count() > 0) {
        $polyclinic = $doctor->clinics->first()->name;
    }
    
    $avatarName = urlencode($doctorName);
@endphp
<header class="topbar d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
        Hub Beranda dokter  
    </div>
    
    <div class="d-flex align-items-center gap-4">
        <div class="d-flex align-items-center gap-2 border-start ps-4">
            <div class="text-end d-none d-md-block">
                <div class="fw-semibold text-dark" style="font-size: 0.9rem;"><span class="fw-semibold">{{ $doctorName }}</span></div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $polyclinic }}</div>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ $avatarName }}&background=random" alt="Profile" class="rounded-circle" width="40" height="40">
        </div>
    </div>
</header>