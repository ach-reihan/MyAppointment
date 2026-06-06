<header class="topbar d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
        Hub Beranda dokter  
    </div>
    
    <div class="d-flex align-items-center gap-4">
        <div class="d-flex align-items-center gap-2 border-start ps-4">
            <div class="text-end d-none d-md-block">
                <div class="fw-semibold text-dark" style="font-size: 0.9rem;"><span class="fw-semibold">{{ $doctorName ?? 'Dr. Healthink S.Ked, M.Ked' }}</span></div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $polyclinic ?? 'Poli Umum' }}</div>
            </div>
            <img src="https://ui-avatars.com/api/?name=Healthink&background=random" alt="Profile" class="rounded-circle" width="40" height="40">
        </div>
    </div>
</header>