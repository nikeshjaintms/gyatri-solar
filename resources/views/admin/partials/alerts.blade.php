@if(session('success'))
    <div class="alert-solar-success alert alert-dismissible" role="alert" style="margin-bottom: 24px;">
        <i class="bi bi-check-circle-fill text-success fs-5"></i>
        <span class="fw-semibold text-success">{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert-solar-error alert alert-dismissible" role="alert" style="margin-bottom: 24px;">
        <i class="bi bi-exclamation-circle-fill text-danger fs-5"></i>
        <span class="fw-semibold text-danger">{{ session('error') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert" style="margin-bottom: 24px; background-color: #FFFBEB; border-color: #FDE68A; color: #B45309;">
        <i class="bi bi-exclamation-triangle-fill fs-5 me-2" style="color: #D97706;"></i>
        <span class="fw-semibold">{{ session('warning') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible" role="alert" style="margin-bottom: 24px; background-color: #EFF6FF; border-color: #BFDBFE; color: #1D4ED8;">
        <i class="bi bi-info-circle-fill fs-5 me-2" style="color: #2563EB;"></i>
        <span class="fw-semibold">{{ session('info') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert-solar-error alert alert-dismissible" role="alert" style="margin-bottom: 24px;">
        <div class="d-flex align-items-start gap-2">
            <i class="bi bi-exclamation-triangle-fill text-danger mt-1 flex-shrink-0"></i>
            <div>
                <strong class="text-danger d-block mb-1" style="font-size:0.88rem;">Please fix the following errors:</strong>
                <ul class="mb-0 ps-3" style="font-size:0.85rem; color:#dc2626;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
