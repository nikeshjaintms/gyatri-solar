@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    .tracking-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid var(--border-soft);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    .metric-badge-box {
        background: #F9FAFB;
        border: 1px solid var(--border-soft);
        border-radius: 12px;
        padding: 14px 18px;
        transition: all 0.2s ease;
    }
    .metric-badge-box:hover {
        background: #FFF7ED;
        border-color: rgba(245, 130, 32, 0.3);
        transform: translateY(-2px);
    }
    .metric-icon-wrap {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    #trackingMap {
        height: 520px;
        width: 100%;
        border-radius: 12px;
        z-index: 1;
        border: 1px solid var(--border-soft);
    }
    .live-pulse-marker {
        position: relative;
    }
    .pulse-ring {
        position: absolute;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(245, 130, 32, 0.4);
        animation: pulse-animation 2s infinite ease-out;
        top: -6px;
        left: -6px;
    }
    @keyframes pulse-animation {
        0% { transform: scale(0.6); opacity: 1; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    .timeline-container {
        max-height: 520px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--brand-orange) transparent;
    }
    .timeline-container::-webkit-scrollbar { width: 4px; }
    .timeline-container::-webkit-scrollbar-thumb { background: var(--brand-orange); border-radius: 4px; }
    
    .timeline-item {
        position: relative;
        padding-left: 28px;
        padding-bottom: 18px;
        border-left: 2px solid #E5E7EB;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .timeline-item:hover {
        background: #FFF7ED;
        border-radius: 8px;
        padding: 6px 6px 12px 28px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -7px;
        top: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #9CA3AF;
        border: 2px solid #FFFFFF;
        box-shadow: 0 0 0 2px #E5E7EB;
    }
    .timeline-item.start-point::before {
        background: #10B981;
        box-shadow: 0 0 0 2px #10B981;
    }
    .timeline-item.latest-point::before {
        background: var(--brand-orange);
        box-shadow: 0 0 0 2px var(--brand-orange);
    }
    .timeline-item:last-child {
        border-left-color: transparent;
    }
    .schedule-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        background: #FEF3C7;
        color: #92400E;
        border: 1px solid #FDE68A;
    }
</style>

<div class="container-fluid p-0">
    <div class="tracking-card p-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 pb-3 border-bottom">
            <div>
                <h4 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-geo-alt-fill text-warning" style="color: var(--brand-orange) !important;"></i>
                    Employee Live GPS Tracking & Route History
                </h4>
                <div class="text-muted small">
                    Track field movements, view 5-minute interval routes, and inspect location accuracy during operational hours (7:00 AM – 7:00 PM).
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="schedule-badge">
                    <i class="bi bi-clock-history me-1"></i> Tracking Schedule: 07:00 AM – 07:00 PM
                </span>
                <div class="form-check form-switch ms-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="autoRefreshToggle" checked>
                    <label class="form-check-label small fw-semibold text-secondary" for="autoRefreshToggle">
                        Live Auto-Refresh (30s)
                    </label>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('employee-locations.index') }}" id="filterForm" class="row g-3 align-items-end pt-3">
            <div class="col-12 col-md-5 col-lg-4">
                <label for="employeeSelect" class="form-label small fw-bold text-secondary mb-1">Select Employee</label>
                <select name="employee_id" id="employeeSelect" class="form-select border-1" onchange="document.getElementById('filterForm').submit();">
                    <option value="">-- Choose Employee --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ (string)$selectedEmployeeId === (string)$emp->id ? 'selected' : '' }}>
                            {{ $emp->user?->name ?? 'Unknown' }} ({{ $emp->employee_id }}) - {{ $emp->designation ?? $emp->department }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-4 col-lg-3">
                <label for="dateSelect" class="form-label small fw-bold text-secondary mb-1">Tracking Date</label>
                <input type="date" name="date" id="dateSelect" class="form-control" value="{{ $selectedDate }}" max="{{ date('Y-m-d') }}" onchange="document.getElementById('filterForm').submit();">
            </div>

            <div class="col-12 col-md-3 col-lg-5 d-flex gap-2">
                <button type="submit" class="btn btn-dark px-4 fw-semibold d-inline-flex align-items-center gap-2" style="background: var(--brand-black);">
                    <i class="bi bi-filter"></i> Apply Filter
                </button>
                <button type="button" id="btnToday" class="btn btn-outline-secondary px-3" onclick="setFilterDate('{{ date('Y-m-d') }}')">
                    Today
                </button>
                <button type="button" id="btnYesterday" class="btn btn-outline-secondary px-3" onclick="setFilterDate('{{ \Carbon\Carbon::yesterday()->toDateString() }}')">
                    Yesterday
                </button>
                <button type="button" id="btnManualRefresh" class="btn btn-outline-warning text-dark px-3 ms-auto" title="Refresh Live Map Data">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
        </form>
    </div>

    @if($selectedEmployee)
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="metric-badge-box d-flex align-items-center gap-3">
                    <div class="metric-icon-wrap" style="background: #E0F2FE; color: #0284C7;">
                        <i class="bi bi-pin-map-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Recorded Pings</div>
                        <h4 class="fw-bold mb-0 text-dark" id="metricTotalPoints">{{ $metrics['total_points'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="metric-badge-box d-flex align-items-center gap-3">
                    <div class="metric-icon-wrap" style="background: #DCFCE7; color: #16A34A;">
                        <i class="bi bi-signpost-split-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Est. Distance</div>
                        <h4 class="fw-bold mb-0 text-dark">
                            <span id="metricTotalDistance">{{ $metrics['total_distance_km'] }}</span> <span class="fs-6 fw-normal text-muted">km</span>
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="metric-badge-box d-flex align-items-center gap-3">
                    <div class="metric-icon-wrap" style="background: #FEF3C7; color: #D97706;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Active Window</div>
                        <div class="fw-bold text-dark" id="metricTimeWindow" style="font-size: 0.95rem;">
                            @if($metrics['start_time'])
                                {{ $metrics['start_time'] }} – {{ $metrics['end_time'] }}
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="metric-badge-box d-flex align-items-center gap-3">
                    <div class="metric-icon-wrap" style="background: #FEE2E2; color: #DC2626;">
                        <i class="bi bi-battery-charging"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Latest Battery</div>
                        <h4 class="fw-bold mb-0 text-dark" id="metricBattery">
                            @if($metrics['latest_battery'] !== null)
                                {{ $metrics['latest_battery'] }}%
                            @else
                                <span class="text-muted fs-6 fw-normal">N/A</span>
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-8">
                <div class="tracking-card p-3 h-100 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-dark px-3 py-2 rounded-3" style="background: var(--brand-black) !important;">
                                <i class="bi bi-person-badge me-1"></i> {{ $selectedEmployee->user?->name ?? 'Employee' }} ({{ $selectedEmployee->employee_id }})
                            </span>
                            <span class="badge bg-light text-secondary border px-3 py-2 rounded-3">
                                <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnFitMap" title="Fit Map to All Route Points">
                                <i class="bi bi-arrows-fullscreen me-1"></i> Fit Route
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-dark" id="btnFocusLatest" title="Center Map on Latest GPS Pin">
                                <i class="bi bi-crosshair me-1"></i> Latest Position
                            </button>
                        </div>
                    </div>

                    <div id="trackingMap"></div>

                    <div class="mt-3 px-2 d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted small">
                        <div class="d-flex align-items-center gap-3">
                            <span><i class="bi bi-circle-fill text-success me-1"></i> Start Point</span>
                            <span><i class="bi bi-circle-fill text-warning me-1" style="color: var(--brand-orange) !important;"></i> Latest Position</span>
                            <span><i class="bi bi-dash-lg text-primary me-1 fw-bold"></i> Route Path</span>
                        </div>
                        <div id="mapStatusText" class="fst-italic">
                            Map ready.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="tracking-card p-3 h-100 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="bi bi-list-nested me-1"></i> Location Pings Timeline
                        </h6>
                        <span class="badge bg-secondary rounded-pill" id="timelineCountBadge">
                            {{ $locations->count() }} Points
                        </span>
                    </div>

                    <div class="timeline-container pe-2 flex-grow-1" id="timelineList">
                        @forelse($locations as $index => $loc)
                            @php
                                $isStart = ($index === 0);
                                $isLatest = ($index === $locations->count() - 1);
                                $itemClass = $isStart ? 'start-point' : ($isLatest ? 'latest-point' : '');
                            @endphp
                            <div class="timeline-item {{ $itemClass }}" onclick="focusPoint({{ $loc->latitude }}, {{ $loc->longitude }}, '{{ \Carbon\Carbon::parse($loc->tracked_at)->format('h:i:s A') }}', {{ $loc->accuracy ?? 0 }}, {{ $loc->battery_level ?? 'null' }})">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold text-dark small">
                                        {{ \Carbon\Carbon::parse($loc->tracked_at)->format('h:i:s A') }}
                                    </span>
                                    @if($loc->battery_level !== null)
                                        <span class="badge bg-light text-muted border small">
                                            <i class="bi bi-battery-half text-success me-1"></i>{{ $loc->battery_level }}%
                                        </span>
                                    @endif
                                </div>
                                <div class="text-secondary small font-monospace">
                                    {{ number_format($loc->latitude, 5) }}, {{ number_format($loc->longitude, 5) }}
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    @if($loc->accuracy !== null)
                                        <span class="badge {{ $loc->accuracy <= 25 ? 'bg-success' : ($loc->accuracy <= 70 ? 'bg-warning text-dark' : 'bg-danger') }} small" style="font-size: 0.7rem;">
                                            ±{{ round($loc->accuracy) }}m
                                        </span>
                                    @endif
                                    @if($loc->speed !== null && $loc->speed > 0)
                                        <span class="badge bg-info text-dark small" style="font-size: 0.7rem;">
                                            {{ round($loc->speed, 1) }} km/h
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-geo-alt fs-1 text-secondary opacity-50 mb-2 d-block"></i>
                                <h6 class="fw-semibold text-secondary">No Location Records Found</h6>
                                <p class="small mb-0">
                                    No GPS coordinates were uploaded by this employee on {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="tracking-card p-5 text-center">
            <i class="bi bi-people fs-1 text-secondary mb-3 d-block"></i>
            <h5 class="fw-bold text-dark">No Active Employees Available</h5>
            <p class="text-muted mb-3">Please ensure employees are registered and set to Active status in the system.</p>
            <a href="{{ route('employees.index') }}" class="btn btn-dark">
                <i class="bi bi-person-plus me-1"></i> Manage Employees
            </a>
        </div>
    @endif
</div>

<script>
    let map = null;
    let polyline = null;
    let markers = [];
    let livePulseMarker = null;
    let autoRefreshTimer = null;

    const selectedEmployeeId = {{ $selectedEmployeeId ? (int)$selectedEmployeeId : 'null' }};
    const selectedDate = @json($selectedDate);

    function setFilterDate(dateStr) {
        document.getElementById('dateSelect').value = dateStr;
        document.getElementById('filterForm').submit();
    }

    function initMap(points) {
        const mapContainer = document.getElementById('trackingMap');
        if (!mapContainer) return;

        if (!map) {
            map = L.map('trackingMap', {
                zoomControl: true,
                attributionControl: false
            }).setView([20.5937, 78.9629], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);
        }

        renderRoute(points);
    }

    function renderRoute(points) {
        markers.forEach(m => map.removeLayer(m));
        markers = [];
        if (polyline) {
            map.removeLayer(polyline);
            polyline = null;
        }

        if (!points || points.length === 0) {
            document.getElementById('mapStatusText').innerHTML = '<span class="text-secondary">No GPS points recorded for this date.</span>';
            return;
        }

        const latlngs = [];

        points.forEach((pt, index) => {
            const latlng = [pt.lat, pt.lng];
            latlngs.push(latlng);

            const isStart = (index === 0);
            const isLatest = (index === points.length - 1);

            let markerHtml = '';
            if (isLatest) {
                markerHtml = `<div class="live-pulse-marker"><div class="pulse-ring"></div><i class="bi bi-geo-alt-fill text-warning fs-4" style="color: #F58220 !important;"></i></div>`;
            } else if (isStart) {
                markerHtml = `<i class="bi bi-geo-alt-fill text-success fs-4"></i>`;
            } else {
                markerHtml = `<div style="background: #0B0B0B; color: #FFF; width: 18px; height: 18px; border-radius: 50%; font-size: 9px; font-weight: bold; display: flex; align-items: center; justify-content: center; border: 2px solid #FFF;">${index + 1}</div>`;
            }

            const customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: markerHtml,
                iconSize: [24, 24],
                iconAnchor: [12, isLatest || isStart ? 24 : 12]
            });

            const marker = L.marker(latlng, { icon: customIcon }).addTo(map);

            const popupContent = `
                <div style="font-family: 'Inter', sans-serif; font-size: 12px; line-height: 1.5; min-width: 170px;">
                    <div style="font-weight: 700; color: #111827; border-bottom: 1px solid #E5E7EB; padding-bottom: 4px; margin-bottom: 4px;">
                        ${isLatest ? '📍 Latest Position' : (isStart ? '🏁 Start Point' : `Point #${index + 1}`)}
                    </div>
                    <div><b>Time:</b> ${pt.time || 'N/A'}</div>
                    <div><b>Coords:</b> ${pt.lat.toFixed(5)}, ${pt.lng.toFixed(5)}</div>
                    <div><b>Accuracy:</b> ${pt.accuracy ? '±' + Math.round(pt.accuracy) + 'm' : 'N/A'}</div>
                    <div><b>Speed:</b> ${pt.speed ? pt.speed + ' km/h' : '0 km/h'}</div>
                    <div><b>Battery:</b> ${pt.battery !== null && pt.battery !== undefined ? pt.battery + '%' : 'N/A'}</div>
                </div>
            `;
            marker.bindPopup(popupContent);
            markers.push(marker);
        });

        polyline = L.polyline(latlngs, {
            color: '#F58220',
            weight: 4,
            opacity: 0.85,
            smoothFactor: 1
        }).addTo(map);

        map.fitBounds(polyline.getBounds(), { padding: [40, 40] });

        document.getElementById('mapStatusText').innerHTML = `<span class="text-success"><i class="bi bi-check2-circle me-1"></i>Showing ${points.length} GPS points.</span>`;
    }

    function focusPoint(lat, lng, time, accuracy, battery) {
        if (!map) return;
        map.setView([lat, lng], 17);

        const marker = markers.find(m => {
            const pos = m.getLatLng();
            return Math.abs(pos.lat - lat) < 0.00001 && Math.abs(pos.lng - lng) < 0.00001;
        });

        if (marker) {
            marker.openPopup();
        }
    }

    function fetchLiveGPSData() {
        if (!selectedEmployeeId) return;

        fetch(`{{ route('employee-locations.data') }}?employee_id=${selectedEmployeeId}&date=${selectedDate}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    renderRoute(data.points);
                    if (data.metrics) {
                        document.getElementById('metricTotalPoints').textContent = data.metrics.total_points;
                        document.getElementById('metricTotalDistance').textContent = data.metrics.total_distance_km;
                        document.getElementById('metricBattery').textContent = data.metrics.latest_battery !== null ? data.metrics.latest_battery + '%' : 'N/A';
                        if (data.metrics.start_time) {
                            document.getElementById('metricTimeWindow').textContent = `${data.metrics.start_time} – ${data.metrics.end_time}`;
                        }
                    }
                }
            })
            .catch(err => console.error('GPS Refresh error:', err));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialPoints = [
            @foreach($locations as $loc)
            {
                id: {{ $loc->id }},
                lat: {{ (float)$loc->latitude }},
                lng: {{ (float)$loc->longitude }},
                accuracy: {{ $loc->accuracy ? (float)$loc->accuracy : 'null' }},
                speed: {{ $loc->speed ? (float)$loc->speed : 'null' }},
                battery: {{ $loc->battery_level !== null ? (int)$loc->battery_level : 'null' }},
                time: "{{ \Carbon\Carbon::parse($loc->tracked_at)->format('h:i:s A') }}"
            },
            @endforeach
        ];

        initMap(initialPoints);

        const btnFitMap = document.getElementById('btnFitMap');
        if (btnFitMap) {
            btnFitMap.addEventListener('click', function() {
                if (polyline && map) {
                    map.fitBounds(polyline.getBounds(), { padding: [40, 40] });
                }
            });
        }

        const btnFocusLatest = document.getElementById('btnFocusLatest');
        if (btnFocusLatest) {
            btnFocusLatest.addEventListener('click', function() {
                if (markers.length > 0 && map) {
                    const latestMarker = markers[markers.length - 1];
                    map.setView(latestMarker.getLatLng(), 17);
                    latestMarker.openPopup();
                }
            });
        }

        const btnManualRefresh = document.getElementById('btnManualRefresh');
        if (btnManualRefresh) {
            btnManualRefresh.addEventListener('click', function() {
                btnManualRefresh.classList.add('fa-spin');
                fetchLiveGPSData();
                setTimeout(() => btnManualRefresh.classList.remove('fa-spin'), 1000);
            });
        }

        const toggle = document.getElementById('autoRefreshToggle');
        function setupAutoRefresh() {
            if (autoRefreshTimer) clearInterval(autoRefreshTimer);
            if (toggle && toggle.checked) {
                autoRefreshTimer = setInterval(fetchLiveGPSData, 30000);
            }
        }

        if (toggle) {
            toggle.addEventListener('change', setupAutoRefresh);
            setupAutoRefresh();
        }
    });
</script>
@endsection
