@extends(in_array(Auth::user()->role ?? '', ['Super Admin', 'Admin', 'Manager']) ? 'layouts.admin' : 'layouts.employee')

@section('content')

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-clock-history"></i></span>
        Daily attendance Punch
    </h1>
    @if(in_array(Auth::user()->role ?? '', ['Super Admin', 'Admin', 'Manager']))
        <a href="{{ route('employee-attendances.index') }}" class="btn-back">
            <i class="bi bi-list-check"></i> View History
        </a>
    @endif
</div>

<div class="row justify-content-center mt-4">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="background: #ffffff; border: 1px solid #dee2e6 !important;">
            
            {{-- Alert message if permission denied --}}
            <div id="locationAlert" class="alert alert-danger d-none" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <span id="locationAlertText">Please enable location permission.</span>
            </div>

            @include('admin.partials.alerts')

            {{-- Today's Status Header --}}
            <div class="text-center mb-4">
                <h5 class="text-secondary fw-semibold mb-2">Today's Date</h5>
                <h3 class="fw-bold text-dark mb-3">{{ date('d M Y') }}</h3>
                
                <div class="d-inline-block py-2 px-4 rounded-3 border" style="background: #FFF7ED; border-color: rgba(245,130,32,0.2) !important;">
                    <span class="text-muted small d-block">Current Status</span>
                    @if(!$todayAttendance)
                        <span class="fw-bold" style="color: var(--brand-orange);">Not Punched In</span>
                    @elseif($todayAttendance && !$todayAttendance->punch_out_time)
                        <span class="fw-bold text-success">Punched In ({{ \Carbon\Carbon::parse($todayAttendance->punch_in_time)->format('h:i A') }})</span>
                    @else
                        <span class="fw-bold text-secondary">Attendance Completed</span>
                    @endif
                </div>
            </div>

            <div class="row g-3">
                {{-- Punch In Form --}}
                <div class="col-6">
                    <form action="{{ route('employee.attendance.punch-in') }}" method="POST" id="punchInForm">
                        @csrf
                        <input type="hidden" name="latitude" class="lat-field">
                        <input type="hidden" name="longitude" class="lon-field">
                        <input type="hidden" name="address" class="addr-field">
                        
                        <button type="button" id="btnPunchIn" class="w-100 py-4 btn rounded-4 fw-bold border-0 text-white d-flex flex-column align-items-center justify-content-center gap-2"
                                style="background: linear-gradient(135deg, #F58220 0%, #FF9F43 100%); transition: all 0.3s;"
                                {{ $todayAttendance ? 'disabled' : '' }}>
                            <i class="bi bi-box-arrow-in-right fs-1"></i>
                            <span>Punch In</span>
                        </button>
                    </form>
                </div>

                {{-- Punch Out Form --}}
                <div class="col-6">
                    @if($todayAttendance)
                        <form action="{{ route('employee.attendance.punch-out', $todayAttendance->id) }}" method="POST" id="punchOutForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="latitude" class="lat-field">
                            <input type="hidden" name="longitude" class="lon-field">
                            <input type="hidden" name="address" class="addr-field">
                            
                            <button type="button" id="btnPunchOut" class="w-100 py-4 btn rounded-4 fw-bold border-0 text-white d-flex flex-column align-items-center justify-content-center gap-2"
                                    style="background: #111111; transition: all 0.3;"
                                    {{ $todayAttendance->punch_out_time ? 'disabled' : '' }}>
                                <i class="bi bi-box-arrow-left fs-1" style="color: var(--brand-orange);"></i>
                                <span style="color: var(--brand-orange);">Punch Out</span>
                            </button>
                        </form>
                    @else
                        <button type="button" class="w-100 py-4 btn rounded-4 fw-bold border-0 text-muted d-flex flex-column align-items-center justify-content-center gap-2"
                                style="background: #e9ecef; cursor: not-allowed;" disabled>
                            <i class="bi bi-box-arrow-left fs-1"></i>
                            <span>Punch Out</span>
                        </button>
                    @endif
                </div>
            </div>

            @if($todayAttendance && $todayAttendance->punch_out_time)
                <div class="text-center mt-4">
                    <span class="badge bg-success px-4 py-2 rounded-pill fs-6 fw-bold">
                        <i class="bi bi-check-circle-fill me-1"></i> Attendance Completed
                    </span>
                </div>
            @endif

            {{-- Live Location Detail Card --}}
            <div class="mt-4 p-3 rounded-3 border" style="background: #fafafa;">
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary">
                    <i class="bi bi-geo-alt-fill text-warning"></i>
                    <span class="small fw-semibold">Live GPS Location Details</span>
                </div>
                <div id="gpsStatus" class="small text-muted">
                    Checking location permissions...
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const latFields = document.querySelectorAll('.lat-field');
    const lonFields = document.querySelectorAll('.lon-field');
    const addrFields = document.querySelectorAll('.addr-field');
    const gpsStatus = document.getElementById('gpsStatus');
    const locationAlert = document.getElementById('locationAlert');
    const locationAlertText = document.getElementById('locationAlertText');
    const btnPunchIn = document.getElementById('btnPunchIn');
    const btnPunchOut = document.getElementById('btnPunchOut');

    let latitude = null;
    let longitude = null;
    let address = "";

    // Disable button styling helper
    function updateButtonStates(allowed) {
        if (!allowed) {
            if (btnPunchIn) {
                btnPunchIn.style.opacity = '0.5';
                btnPunchIn.style.cursor = 'not-allowed';
            }
            if (btnPunchOut) {
                btnPunchOut.style.opacity = '0.5';
                btnPunchOut.style.cursor = 'not-allowed';
            }
        } else {
            if (btnPunchIn && !btnPunchIn.disabled) {
                btnPunchIn.style.opacity = '1';
                btnPunchIn.style.cursor = 'pointer';
            }
            if (btnPunchOut && !btnPunchOut.disabled) {
                btnPunchOut.style.opacity = '1';
                btnPunchOut.style.cursor = 'pointer';
            }
        }
    }

    // Function to acquire geolocation coordinates
    function requestLocation() {
        if (!navigator.geolocation) {
            gpsStatus.innerHTML = '<span class="text-danger">Geolocation is not supported by your browser.</span>';
            locationAlertText.textContent = "Geolocation is not supported by your browser.";
            locationAlert.classList.remove('d-none');
            updateButtonStates(false);
            return;
        }

        gpsStatus.innerHTML = '<span class="text-warning"><span class="spinner-border spinner-border-sm me-1" role="status"></span>Acquiring GPS Signal...</span>';

        navigator.geolocation.getCurrentPosition(
            function(position) {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
                locationAlert.classList.add('d-none');

                latFields.forEach(f => f.value = latitude);
                lonFields.forEach(f => f.value = longitude);

                // OSM Reverse Geocoding API (Nominatim)
                gpsStatus.innerHTML = `<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>GPS Acquired (${latitude.toFixed(5)}, ${longitude.toFixed(5)})</span><br><span class="text-muted mt-1 d-block">Resolving address...</span>`;
                
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`)
                    .then(response => response.json())
                    .then(data => {
                        address = data.display_name || `Lat: ${latitude}, Lon: ${longitude}`;
                        addrFields.forEach(f => f.value = address);
                        gpsStatus.innerHTML = `<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>GPS Signal Lock</span><br><span class="text-dark mt-1 d-block font-monospace" style="font-size:0.75rem;">${address}</span>`;
                        updateButtonStates(true);
                    })
                    .catch(err => {
                        address = `Lat: ${latitude}, Lon: ${longitude}`;
                        addrFields.forEach(f => f.value = address);
                        gpsStatus.innerHTML = `<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>GPS Signal Lock</span><br><span class="text-dark mt-1 d-block font-monospace" style="font-size:0.75rem;">${address}</span>`;
                        updateButtonStates(true);
                    });
            },
            function(error) {
                let errorMsg = "Please enable location permission.";
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        errorMsg = "Location permission denied. Please enable location services in your browser.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMsg = "Location information is unavailable.";
                        break;
                    case error.TIMEOUT:
                        errorMsg = "The request to get user location timed out.";
                        break;
                }
                gpsStatus.innerHTML = `<span class="text-danger"><i class="bi bi-x-circle-fill me-1"></i>${errorMsg}</span>`;
                locationAlertText.textContent = errorMsg;
                locationAlert.classList.remove('d-none');
                updateButtonStates(false);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    // Call geolocation request on page load
    requestLocation();

    // Event listener triggers check location before submit
    if (btnPunchIn) {
        btnPunchIn.addEventListener('click', function(e) {
            if (!latitude || !longitude) {
                locationAlertText.textContent = "Please enable location permission and wait for GPS signal.";
                locationAlert.classList.remove('d-none');
                return;
            }
            btnPunchIn.disabled = true;
            btnPunchIn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Punching In...';
            document.getElementById('punchInForm').submit();
        });
    }

    if (btnPunchOut) {
        btnPunchOut.addEventListener('click', function(e) {
            if (!latitude || !longitude) {
                locationAlertText.textContent = "Please enable location permission and wait for GPS signal.";
                locationAlert.classList.remove('d-none');
                return;
            }
            btnPunchOut.disabled = true;
            btnPunchOut.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Punching Out...';
            document.getElementById('punchOutForm').submit();
        });
    }
});
</script>

@endsection
