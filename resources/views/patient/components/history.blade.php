<a href="{{ route('patient.MedicalHistory.Detail', $history['id']) }}" class="text-decoration-none text-dark d-block mb-3">
    <div class="card border-0 shadow-sm rounded-4 transition-hover">
        <div class="card-body p-3 d-flex align-items-center">

            @php
                $dateParts = explode(' ', $history['date']); 
                $day = $dateParts[0] ?? '-';
                $month = isset($dateParts[1]) ? strtoupper(substr($dateParts[1], 0, 3)) : '-';
            @endphp
            
            <div class="bg-light rounded-3 text-center p-2 me-4 date-badge-box">
                <div class="text-muted small fw-bold text-uppercase text-xxs">
                    {{ $month }}
                </div>
                <div class="fw-bold fs-4 text-dark line-height-1">{{ $day }}</div>
            </div>

            <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">{{ $history['doctor'] }}</h6>
                <div class="text-muted small mb-2">{{ $history['clinic'] }} • {{ $history['type'] }}</div>

                <div class="d-flex gap-2">
                    @if($history['is_cancelled'] ?? false)
                        <span class="badge badge-subtle-danger rounded-pill px-3 py-2 fw-normal text-truncate badge-max-width">
                            <i class="bi bi-x-circle me-1"></i> {{ $history['diagnosis'] }}
                        </span>
                    @else
                        <span class="badge badge-subtle-secondary rounded-pill px-3 py-2 fw-normal text-truncate badge-max-width">
                            <i class="bi bi-clipboard2-pulse me-1"></i> {{ $history['diagnosis'] }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="d-flex flex-column gap-3 text-muted ms-3">
                <i class="bi bi-chevron-right fs-5"></i>
            </div>
            
        </div>
    </div>
</a>