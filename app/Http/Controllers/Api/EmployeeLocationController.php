<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeLocationRequest;
use App\Models\Employee;
use App\Models\EmployeeLocation;
use App\Services\EmployeeLocationService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class EmployeeLocationController extends Controller
{
    public function __construct(
        protected EmployeeLocationService $locationService
    ) {}

    public function store(StoreEmployeeLocationRequest $request): JsonResponse
    {
        $user = $request->user();

        $employee = $user->employee;
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Authenticated user does not have a linked employee profile.',
            ], 422);
        }

        if ($request->has('locations') && is_array($request->input('locations'))) {
            $result = $this->locationService->recordBatch($employee, $request->input('locations'));

            return response()->json([
                'success' => true,
                'message' => "Successfully synchronized {$result['saved_count']} location point(s).",
                'data' => [
                    'saved_count' => $result['saved_count'],
                    'duplicate_count' => $result['duplicate_count'],
                    'employee_id' => $employee->id,
                ],
            ], 201);
        }

        $location = $this->locationService->recordLocation($employee, $request->validated());

        $isWithinSchedule = $this->locationService->isWithinTrackingSchedule(
            $location->tracked_at ? Carbon::parse($location->tracked_at) : null
        );

        return response()->json([
            'success' => true,
            'message' => 'Location recorded successfully.',
            'data' => [
                'id' => $location->id,
                'employee_id' => $location->employee_id,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'accuracy' => $location->accuracy,
                'speed' => $location->speed,
                'battery_level' => $location->battery_level,
                'tracked_at' => $location->tracked_at?->toIso8601String(),
                'sync_id' => $location->sync_id,
                'within_schedule' => $isWithinSchedule,
            ],
        ], 201);
    }
}
