<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_id', 'like', '%' . $search . '%')
                  ->orWhere('aadhaar_number', 'like', '%' . $search . '%')
                  ->orWhere('utr_number', 'like', '%' . $search . '%')
                  ->orWhere('department', 'like', '%' . $search . '%')
                  ->orWhere('designation', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%')
                         ->orWhere('mobile_number', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('user', function ($uq) use ($request) {
                $uq->where('status', $request->status);
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $employees = $query->latest()->paginate(10)->withQueryString();

        // Get unique departments for filter dropdown
        $departments = Employee::select('department')->distinct()->pluck('department');

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $nextEmployeeId = $this->generateEmployeeId();
        return view('admin.employees.create', compact('nextEmployeeId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users,mobile_number'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'aadhaar_number' => ['required', 'numeric', 'digits:12', 'unique:employees,aadhaar_number'],
            'utr_number' => ['nullable', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'designation' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'joining_date' => ['required', 'date', 'before_or_equal:today'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'address' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                $profilePhotoPath = null;
                if ($request->hasFile('profile_photo')) {
                    $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
                }

                $user = User::create([
                    'name' => trim(strip_tags($request->name)),
                    'email' => trim(strip_tags($request->email)),
                    'password' => Hash::make($request->password),
                    'mobile_number' => trim(strip_tags($request->mobile_number)),
                    'role' => 'Employee',
                    'status' => $request->status,
                    'profile_photo' => $profilePhotoPath,
                    'address' => trim(strip_tags($request->address)),
                ]);

                Employee::create([
                    'user_id' => $user->id,
                    'employee_id' => $this->generateEmployeeId(),
                    'aadhaar_number' => trim(strip_tags($request->aadhaar_number)),
                    'utr_number' => $request->utr_number ? trim(strip_tags($request->utr_number)) : null,
                    'department' => trim(strip_tags($request->department)),
                    'designation' => trim(strip_tags($request->designation)),
                    'joining_date' => $request->joining_date,
                    'salary' => $request->salary,
                ]);
            });

            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create employee. ' . $e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $user = $employee->user;

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users,mobile_number,' . $user->id],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'aadhaar_number' => [
                'required',
                'numeric',
                'digits:12',
                Rule::unique('employees', 'aadhaar_number')->ignore($employee->id),
            ],
            'utr_number' => ['nullable', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'designation' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'joining_date' => ['required', 'date', 'before_or_equal:today'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'address' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        try {
            DB::transaction(function () use ($request, $employee, $user) {
                $profilePhotoPath = $user->profile_photo;
                if ($request->hasFile('profile_photo')) {
                    if ($profilePhotoPath && Storage::disk('public')->exists($profilePhotoPath)) {
                        Storage::disk('public')->delete($profilePhotoPath);
                    }
                    $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
                }

                $userUpdateData = [
                    'name' => trim(strip_tags($request->name)),
                    'email' => trim(strip_tags($request->email)),
                    'mobile_number' => trim(strip_tags($request->mobile_number)),
                    'status' => $request->status,
                    'profile_photo' => $profilePhotoPath,
                    'address' => trim(strip_tags($request->address)),
                ];

                if ($request->filled('password')) {
                    $userUpdateData['password'] = Hash::make($request->password);
                }

                $user->update($userUpdateData);

                $employee->update([
                    'aadhaar_number' => trim(strip_tags($request->aadhaar_number)),
                    'utr_number' => $request->utr_number ? trim(strip_tags($request->utr_number)) : null,
                    'department' => trim(strip_tags($request->department)),
                    'designation' => trim(strip_tags($request->designation)),
                    'joining_date' => $request->joining_date,
                    'salary' => $request->salary,
                ]);
            });

            return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update employee. ' . $e->getMessage());
        }
    }

    public function destroy(Employee $employee)
    {
        // Prevent deletion if child records exist
        if (\App\Models\EmployeeAttendance::where('employee_id', $employee->user_id)->exists() ||
            ($employee->user && ($employee->user->enquiries()->exists() || $employee->user->siteSurveys()->exists()))) {
            return redirect()->route('employees.index')->with('error', 'Cannot delete employee because they have active attendances, enquiries, or surveys.');
        }

        try {
            DB::transaction(function () use ($employee) {
                $user = $employee->user;

                if ($user && $user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                $employee->delete();

                if ($user) {
                    $user->delete();
                }
            });

            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'Delete failed. ' . $e->getMessage());
        }
    }

    public function toggleStatus(Employee $employee)
    {
        $user = $employee->user;
        if ($user) {
            $newStatus = $user->status === 'Active' ? 'Inactive' : 'Active';
            $user->update(['status' => $newStatus]);
            return redirect()->back()->with('success', 'Employee status updated to ' . $newStatus . ' successfully.');
        }
        return redirect()->back()->with('error', 'User not found.');
    }

    private function generateEmployeeId()
    {
        $latest = Employee::orderBy('id', 'desc')->first();
        if ($latest) {
            $number = intval(substr($latest->employee_id, 3));
            return 'EMP' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        }
        return 'EMP0001';
    }
}
