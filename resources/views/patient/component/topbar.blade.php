@php
    $loggedInUser = auth()->user();
    $loggedInPatientName = $loggedInUser ? $loggedInUser->name : 'Budi Santoso';
    $loggedInPatientId = ($loggedInUser && $loggedInUser->patient) ? $loggedInUser->patient->id : 'Placeholder';
    $avatarName = urlencode($loggedInPatientName);
@endphp
<header class="topbar d-flex align-items-center justify-content-between">
    <h6 class="mb-0 fw-normal">Hub Beranda Pasien</h6>
    <div class="d-flex align-items-center gap-4">
        <div class="d-flex align-items-center gap-3 border-start ps-4">
            <div class="text-end">
                <div class="fw-bold text-dark" style="font-size: 0.9rem;"><span class="fw-semibold">{{ $loggedInPatientName }}</span></div>
                <div class="text-muted" style="font-size: 0.75rem;">ID: {{ $loggedInPatientId }}</div>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ $avatarName }}&background=random" class="rounded-circle" width="40" height="40" alt="Profile">
        </div>
    </div>
</header>