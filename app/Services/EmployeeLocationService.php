<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeLocation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EmployeeLocationService
{
    public const TRACKING_START_HOUR = 7;
    public const TRACKING_END_HOUR = 19;

    public function isWithinTrackingSchedule(?Carbon $time = null): bool
    {
        $time = $time ?: Carbon::now();
        $start = $time->copy()->setTime(self::TRACKING_START_HOUR, 0, 0);
        $end = $time->copy()->setTime(self::TRACKING_END_HOUR, 0, 0);

        return $time->betweenIncluded($start, $end);
    }

    public function recordLocation(Employee $employee, array $data): EmployeeLocation
    {
        $trackedAt = isset($data['tracked_at']) && !empty($data['tracked_at'])
            ? Carbon::parse($data['tracked_at'])
            : Carbon::now();

        $payload = [
            'employee_id' => $employee->id,
            'latitude' => round((float) $data['latitude'], 7),
            'longitude' => round((float) $data['longitude'], 7),
            'accuracy' => isset($data['accuracy']) && $data['accuracy'] !== null ? round((float) $data['accuracy'], 2) : null,
            'speed' => isset($data['speed']) && $data['speed'] !== null ? max(0, round((float) $data['speed'], 2)) : null,
            'battery_level' => isset($data['battery_level']) && $data['battery_level'] !== null ? max(0, min(100, (int) $data['battery_level'])) : null,
            'tracked_at' => $trackedAt,
            'device_id' => isset($data['device_id']) ? substr((string) $data['device_id'], 0, 191) : null,
            'sync_id' => isset($data['sync_id']) && !empty($data['sync_id']) ? substr((string) $data['sync_id'], 0, 100) : null,
        ];

        if (!empty($payload['sync_id'])) {
            return EmployeeLocation::firstOrCreate(
                ['sync_id' => $payload['sync_id']],
                $payload
            );
        }

        return EmployeeLocation::create($payload);
    }

    public function recordBatch(Employee $employee, array $locations): array
    {
        $savedCount = 0;
        $duplicateCount = 0;

        DB::transaction(function () use ($employee, $locations, &$savedCount, &$duplicateCount) {
            foreach ($locations as $point) {
                if (!isset($point['latitude']) || !isset($point['longitude'])) {
                    continue;
                }

                $syncId = isset($point['sync_id']) && !empty($point['sync_id']) ? substr((string) $point['sync_id'], 0, 100) : null;
                if ($syncId && EmployeeLocation::where('sync_id', $syncId)->exists()) {
                    $duplicateCount++;
                    continue;
                }

                $this->recordLocation($employee, $point);
                $savedCount++;
            }
        });

        return [
            'saved_count' => $savedCount,
            'duplicate_count' => $duplicateCount,
        ];
    }

    public function calculateRouteMetrics($locations): array
    {
        if ($locations->isEmpty()) {
            return [
                'total_points' => 0,
                'total_distance_km' => 0,
                'start_time' => null,
                'end_time' => null,
                'duration_formatted' => '0m',
                'latest_battery' => null,
                'average_accuracy' => null,
                'max_speed' => null,
            ];
        }

        $sorted = $locations->sortBy('tracked_at')->values();
        $totalDistance = 0.0;
        $prev = null;
        $speeds = [];
        $accuracies = [];

        foreach ($sorted as $loc) {
            if ($prev !== null) {
                $dist = $this->haversineGreatCircleDistance(
                    $prev->latitude,
                    $prev->longitude,
                    $loc->latitude,
                    $loc->longitude
                );
                if ($dist < 100) {
                    $totalDistance += $dist;
                }
            }
            $prev = $loc;

            if ($loc->speed !== null && $loc->speed > 0) {
                $speeds[] = $loc->speed;
            }
            if ($loc->accuracy !== null) {
                $accuracies[] = $loc->accuracy;
            }
        }

        $firstPoint = $sorted->first();
        $lastPoint = $sorted->last();
        $start = $firstPoint->tracked_at ? Carbon::parse($firstPoint->tracked_at) : null;
        $end = $lastPoint->tracked_at ? Carbon::parse($lastPoint->tracked_at) : null;

        $durationMinutes = ($start && $end) ? $start->diffInMinutes($end) : 0;
        $hours = intdiv($durationMinutes, 60);
        $minutes = $durationMinutes % 60;
        $durationFormatted = $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";

        return [
            'total_points' => $sorted->count(),
            'total_distance_km' => round($totalDistance, 2),
            'start_time' => $start ? $start->format('h:i A') : null,
            'end_time' => $end ? $end->format('h:i A') : null,
            'duration_formatted' => $durationFormatted,
            'latest_battery' => $lastPoint->battery_level,
            'average_accuracy' => !empty($accuracies) ? round(array_sum($accuracies) / count($accuracies), 1) : null,
            'max_speed' => !empty($speeds) ? round(max($speeds), 1) : null,
        ];
    }

    protected function haversineGreatCircleDistance(float $latFrom, float $lonFrom, float $latTo, float $lonTo, float $earthRadius = 6371.0): float
    {
        $latFrom = deg2rad($latFrom);
        $lonFrom = deg2rad($lonFrom);
        $latTo = deg2rad($latTo);
        $lonTo = deg2rad($lonTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
