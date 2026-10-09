<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeLocation;
use App\Services\EmployeeLocationService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeLocationController extends Controller
{
    public function __construct(
        protected EmployeeLocationService $locationService
    ) {}

    public function index(Request $request): View
    {
        $employees = Employee::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', 'Active');
            })
            ->get()
            ->sortBy('user.name')
            ->values();

        $selectedEmployeeId = $request->filled('employee_id')
            ? (int) $request->input('employee_id')
            : ($employees->first()?->id ?? null);

        $selectedDate = $request->input('date', Carbon::today()->toDateString());

        $selectedEmployee = $selectedEmployeeId ? Employee::with('user')->find($selectedEmployeeId) : null;

        $locations = collect();
        $metrics = $this->locationService->calculateRouteMetrics($locations);

        if ($selectedEmployeeId) {
            $locations = EmployeeLocation::where('employee_id', $selectedEmployeeId)
                ->whereDate('tracked_at', $selectedDate)
                ->orderBy('tracked_at', 'asc')
                ->get();

            $metrics = $this->locationService->calculateRouteMetrics($locations);
        }

        $liveSummary = Employee::with(['user', 'latestLocation'])
            ->whereHas('user', function ($q) {
                $q->where('status', 'Active');
            })
            ->get()
            ->map(function ($emp) {
                $latest = $emp->latestLocation;
                $isLiveToday = $latest && Carbon::parse($latest->tracked_at)->isToday();

                return [
                    'employee_id' => $emp->id,
                    'code' => $emp->employee_id,
                    'name' => $emp->user?->name ?? 'Unknown',
                    'department' => $emp->department,
                    'latest_lat' => $latest?->latitude,
                    'latest_lng' => $latest?->longitude,
                    'latest_time' => $latest && $latest->tracked_at ? Carbon::parse($latest->tracked_at)->format('h:i A') : null,
                    'battery' => $latest?->battery_level,
                    'is_live' => $isLiveToday,
                ];
            });

        return view('admin.employee-locations.index', compact(
            'employees',
            'selectedEmployee',
            'selectedEmployeeId',
            'selectedDate',
            'locations',
            'metrics',
            'liveSummary'
        ));
    }

    public function getData(Request $request): JsonResponse
    {
        $employeeId = $request->input('employee_id');
        $date = $request->input('date', Carbon::today()->toDateString());

        if (!$employeeId) {
            return response()->json([
                'success' => false,
                'message' => 'Employee ID is required.',
            ], 422);
        }

        $employee = Employee::with('user')->find($employeeId);
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.',
            ], 404);
        }

        $locations = EmployeeLocation::where('employee_id', $employeeId)
            ->whereDate('tracked_at', $date)
            ->orderBy('tracked_at', 'asc')
            ->get();

        $metrics = $this->locationService->calculateRouteMetrics($locations);

        $points = $locations->map(function ($loc) {
            return [
                'id' => $loc->id,
                'lat' => (float) $loc->latitude,
                'lng' => (float) $loc->longitude,
                'accuracy' => $loc->accuracy ? (float) $loc->accuracy : null,
                'speed' => $loc->speed ? (float) $loc->speed : null,
                'battery' => $loc->battery_level,
                'time' => $loc->tracked_at ? Carbon::parse($loc->tracked_at)->format('h:i:s A') : '',
                'iso_time' => $loc->tracked_at ? Carbon::parse($loc->tracked_at)->toIso8601String() : '',
            ];
        });

        return response()->json([
            'success' => true,
            'employee' => [
                'id' => $employee->id,
                'code' => $employee->employee_id,
                'name' => $employee->user?->name ?? 'Unknown',
                'department' => $employee->department,
                'designation' => $employee->designation,
            ],
            'date' => $date,
            'metrics' => $metrics,
            'points' => $points,
        ]);
    }
}
