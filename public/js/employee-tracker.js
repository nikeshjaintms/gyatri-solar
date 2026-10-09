(function () {
    'use strict';

    const CONFIG = {
        intervalMs: 5 * 60 * 1000,
        startHour: 7,
        endHour: 19,
        endpoint: '/api/locations/sync',
        apiEndpoint: '/api/locations/sync',
        storageKey: 'gse_offline_location_queue',
        lastTrackKey: 'gse_last_track_timestamp',
        maxQueueSize: 200,
    };

    let timerId = null;
    let isTrackingRunning = false;

    function isWithinTrackingSchedule() {
        const now = new Date();
        const currentHour = now.getHours();
        const currentMinute = now.getMinutes();

        if (currentHour < CONFIG.startHour) return false;
        if (currentHour > CONFIG.endHour) return false;
        if (currentHour === CONFIG.endHour && currentMinute > 0) return false;

        return true;
    }

    function generateSyncId() {
        const timestamp = Date.now();
        const randomPart = Math.random().toString(36).substring(2, 10);
        return `sync_${timestamp}_${randomPart}`;
    }

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) return meta.getAttribute('content');

        const input = document.querySelector('input[name="_token"]');
        return input ? input.value : '';
    }

    async function getBatteryLevel() {
        if ('getBattery' in navigator) {
            try {
                const battery = await navigator.getBattery();
                return Math.round(battery.level * 100);
            } catch (e) {
                return null;
            }
        }
        return null;
    }

    function getOfflineQueue() {
        try {
            const raw = localStorage.getItem(CONFIG.storageKey);
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            return [];
        }
    }

    function saveOfflineQueue(queue) {
        try {
            const trimmed = queue.slice(-CONFIG.maxQueueSize);
            localStorage.setItem(CONFIG.storageKey, JSON.stringify(trimmed));
        } catch (e) {
            console.warn('[GPSTracker] Could not save offline queue:', e);
        }
    }

    function enqueueLocationPoint(point) {
        const queue = getOfflineQueue();
        queue.push(point);
        saveOfflineQueue(queue);
        console.log(`[GPSTracker] Location queued offline. Total in queue: ${queue.length}`);
    }

    async function flushOfflineQueue() {
        const queue = getOfflineQueue();
        if (!queue || queue.length === 0) return;

        if (!navigator.onLine) {
            console.log('[GPSTracker] Offline: Sync postponed.');
            return;
        }

        console.log(`[GPSTracker] Attempting to sync ${queue.length} offline point(s)...`);

        const csrfToken = getCsrfToken();
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken;
        }

        try {
            const response = await fetch(CONFIG.endpoint, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({ locations: queue })
            });

            if (response.ok) {
                const data = await response.json();
                console.log('[GPSTracker] Offline locations synchronized successfully:', data);
                localStorage.removeItem(CONFIG.storageKey);
            } else {
                console.warn('[GPSTracker] Sync returned status:', response.status);
            }
        } catch (error) {
            console.warn('[GPSTracker] Sync failed due to network error:', error);
        }
    }

    async function sendLocationPoint(payload) {
        if (!navigator.onLine) {
            enqueueLocationPoint(payload);
            return;
        }

        const csrfToken = getCsrfToken();
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken;
        }

        try {
            const response = await fetch(CONFIG.endpoint, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                const data = await response.json();
                console.log('[GPSTracker] Location transmitted:', data);
                localStorage.setItem(CONFIG.lastTrackKey, Date.now().toString());

                const queue = getOfflineQueue();
                if (queue.length > 0) {
                    flushOfflineQueue();
                }
            } else {
                console.warn('[GPSTracker] Transmission failed with status:', response.status);
                enqueueLocationPoint(payload);
            }
        } catch (error) {
            console.warn('[GPSTracker] Transmission network error, queueing offline:', error);
            enqueueLocationPoint(payload);
        }
    }

    async function captureAndSendLocation() {
        if (!isWithinTrackingSchedule()) {
            console.log('[GPSTracker] Outside 7:00 AM - 7:00 PM tracking window. Skipping ping.');
            return;
        }

        if (!navigator.geolocation) {
            console.warn('[GPSTracker] Geolocation API is not supported on this device/browser.');
            return;
        }

        const batteryLevel = await getBatteryLevel();

        navigator.geolocation.getCurrentPosition(
            function (position) {
                const payload = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy ? Math.round(position.coords.accuracy * 100) / 100 : null,
                    speed: position.coords.speed ? Math.round(position.coords.speed * 3.6 * 100) / 100 : 0,
                    battery_level: batteryLevel,
                    tracked_at: new Date().toISOString(),
                    device_id: navigator.userAgent.substring(0, 100),
                    sync_id: generateSyncId(),
                };

                if (window.Android && typeof window.Android.onLocationCaptured === 'function') {
                    try {
                        window.Android.onLocationCaptured(payload.latitude, payload.longitude, payload.accuracy);
                    } catch (e) {
                        console.warn('[GPSTracker] Android bridge hook error:', e);
                    }
                }

                sendLocationPoint(payload);
            },
            function (error) {
                console.warn('[GPSTracker] Geolocation error:', error.message, '(Code:', error.code, ')');
            },
            {
                enableHighAccuracy: true,
                timeout: 20000,
                maximumAge: 30000,
            }
        );
    }

    function startTracker() {
        if (isTrackingRunning) return;
        isTrackingRunning = true;

        console.log('[GPSTracker] Initializing 5-minute interval GPS tracker (7 AM - 7 PM)...');

        const lastPing = localStorage.getItem(CONFIG.lastTrackKey);
        const now = Date.now();
        if (!lastPing || (now - parseInt(lastPing, 10)) >= CONFIG.intervalMs) {
            captureAndSendLocation();
        }

        timerId = setInterval(captureAndSendLocation, CONFIG.intervalMs);

        window.addEventListener('online', flushOfflineQueue);

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                const last = localStorage.getItem(CONFIG.lastTrackKey);
                const current = Date.now();
                if (!last || (current - parseInt(last, 10)) >= CONFIG.intervalMs) {
                    captureAndSendLocation();
                }
                flushOfflineQueue();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startTracker);
    } else {
        startTracker();
    }

    window.GayatriGPSTracker = {
        captureNow: captureAndSendLocation,
        flushQueue: flushOfflineQueue,
        getQueue: getOfflineQueue,
        isWithinSchedule: isWithinTrackingSchedule,
    };
})();
