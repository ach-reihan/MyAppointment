<nav class="sidebar">
    <div class="sidebar-brand mb-3">
        <div class="bg-primary text-white rounded p-1 d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
            <i class="bi bi-shield-plus"></i>
        </div>
        <div>
            <h5 class="mb-0 text-primary fw-bold" style="font-size: 1.1rem;">Healthink</h5>
            <small class="text-muted" style="font-size: 0.75rem;">Patient Portal</small>
        </div>
    </div>

    <ul class="nav flex-column sidebar-nav flex-grow-1">
    <li class="nav-item">
        <a href="{{ route('DashboardPatient') }}" 
           class="nav-link d-flex align-items-center gap-3 {{ request()->routeIs('DashboardPatient') ? 'active' : 'text-muted' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('FormAppointment') }}" 
           class="nav-link d-flex align-items-center gap-3 {{ request()->routeIs('FormAppointment') ? 'active' : 'text-muted' }}">
            <i class="bi bi-clipboard2-pulse"></i>
            Buat Janji
        </a>
    </li>
</ul>

    <div class="mt-auto mb-4">
        <ul class="nav flex-column sidebar-nav">
            <li class="nav-item">
                <a href="#" class="nav-link d-flex align-items-center gap-3">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>