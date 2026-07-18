<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAttendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EmployeeAttendance::with('employee');
        $user = Auth::user();

        // If it's a regular Employee or Technician, they only see their own attendance
        if (in_array($user->role, ['Employee', 'Technician'])) {
            $query->where('employee_id', $user->id);
        } else {
            // Admins can search by employee name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('employee', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by From Date
        if ($request->filled('from_date')) {
            $query->whereDate('attendance_date', '>=', $request->from_date);
        }

        // Filter by To Date
        if ($request->filled('to_date')) {
            $query->whereDate('attendance_date', '<=', $request->to_date);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.employee-attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $todayAttendance = EmployeeAttendance::where('employee_id', $user->id)
            ->whereDate('attendance_date', Carbon::today()->toDateString())
            ->first();

        return view('admin.employee-attendances.create', compact('user', 'todayAttendance'));
    }

    /**
     * Store a newly created resource in storage (Punch In).
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Validation: One Punch In per day only
        $existing = EmployeeAttendance::where('employee_id', $user->id)
            ->whereDate('attendance_date', Carbon::today()->toDateString())
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already punched in for today.');
        }

        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'address' => ['nullable', 'string', 'max:1000'],
        ], [
            'latitude.required' => 'Please enable location permission.',
            'longitude.required' => 'Please enable location permission.',
        ]);

        $lat = $request->latitude;
        $lon = $request->longitude;
        $mapUrl = "https://www.google.com/maps?q={$lat},{$lon}";

        EmployeeAttendance::create([
            'employee_id' => $user->id,
            'attendance_date' => Carbon::today()->toDateString(),
            'punch_in_time' => Carbon::now()->toTimeString(),
            'check_in_time' => Carbon::now()->toTimeString(), // Maintain check_in_time for existing system logic
            'status' => 'Present',
            'punch_in_latitude' => $lat,
            'punch_in_longitude' => $lon,
            'punch_in_address' => $request->address ?? "Lat: {$lat}, Lon: {$lon}",
            'punch_in_google_map' => $mapUrl,
        ]);

        return redirect()->back()
            ->with('success', 'Punched in successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = EmployeeAttendance::with('employee')->findOrFail($id);
        return view('admin.employee-attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = EmployeeAttendance::findOrFail($id);
        $employees = User::orderBy('name')->get();
        return view('admin.employee-attendances.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage (Punch Out / Admin Edit).
     */
    public function update(Request $request, string $id)
    {
        $attendance = EmployeeAttendance::findOrFail($id);

        // Distinguish between Admin edit page and Employee punch out
        if ($request->has('employee_id') || $request->has('attendance_date') || $request->has('status')) {
            $request->validate([
                'employee_id' => ['required', 'exists:users,id'],
                'attendance_date' => ['required', 'date'],
                'status' => ['required', 'in:Present,Absent,Half Day,Leave'],
                'check_in_time' => ['nullable'],
                'check_out_time' => ['nullable'],
                'remarks' => ['nullable', 'string', 'max:1000'],
            ]);

            $workMinutes = null;
            if ($request->filled('check_in_time') && $request->filled('check_out_time')) {
                $in = Carbon::parse($request->check_in_time);
                $out = Carbon::parse($request->check_out_time);
                $workMinutes = $in->diffInMinutes($out);
            }

            $attendance->update([
                'employee_id' => $request->employee_id,
                'attendance_date' => $request->attendance_date,
                'status' => $request->status,
                'check_in_time' => $request->check_in_time,
                'check_out_time' => $request->check_out_time,
                'remarks' => trim(strip_tags($request->remarks)),
                'work_minutes' => $workMinutes,
            ]);

            return redirect()->route('employee-attendances.index')->with('success', 'Attendance record updated successfully.');
        }

        // Validation: Punch Out is allowed only after Punch In
        if (!$attendance->punch_in_time) {
            return redirect()->back()->with('error', 'Punch In record is missing.');
        }

        // Validation: Prevent multiple Punch Outs
        if ($attendance->punch_out_time) {
            return redirect()->back()->with('error', 'You have already punched out for today.');
        }

        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'address' => ['nullable', 'string', 'max:1000'],
        ], [
            'latitude.required' => 'Please enable location permission.',
            'longitude.required' => 'Please enable location permission.',
        ]);

        $lat = $request->latitude;
        $lon = $request->longitude;
        $mapUrl = "https://www.google.com/maps?q={$lat},{$lon}";

        $punchInTime = Carbon::parse($attendance->punch_in_time);
        $punchOutTime = Carbon::now();
        $workMinutes = $punchInTime->diffInMinutes($punchOutTime);

        $attendance->update([
            'punch_out_time' => $punchOutTime->toTimeString(),
            'check_out_time' => $punchOutTime->toTimeString(), // Maintain check_out_time for existing system logic
            'work_minutes' => $workMinutes,
            'punch_out_latitude' => $lat,
            'punch_out_longitude' => $lon,
            'punch_out_address' => $request->address ?? "Lat: {$lat}, Lon: {$lon}",
            'punch_out_google_map' => $mapUrl,
        ]);

        return redirect()->back()
            ->with('success', 'Punched out successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = EmployeeAttendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('employee-attendances.index')
            ->with('success', 'Attendance deleted successfully.');
    }
}
