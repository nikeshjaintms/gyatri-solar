<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobAssignment;
use App\Models\ServiceRequest;
use App\Models\Technician;
use Illuminate\Http\Request;

class JobAssignmentController extends Controller
{
    /* ── Sync service request status from job assignment status ── */
    private function syncServiceRequestStatus(JobAssignment $job): void
    {
        try {
            $sr = $job->serviceRequest;
            if (!$sr) return;

            $map = [
                'Assigned'    => 'Assigned',
                'Accepted'    => 'Assigned',
                'In Progress' => 'In Progress',
                'Completed'   => 'Completed',
                'Cancelled'   => 'Cancelled',
            ];

            $newStatus = $map[$job->status] ?? null;

            if ($newStatus && $sr->status !== $newStatus) {
                $sr->status = $newStatus;
                // Also stamp the technician on the service request when assigning
                if (in_array($job->status, ['Assigned', 'Accepted']) && $sr->technician_id !== $job->technician_id) {
                    $sr->technician_id = $job->technician_id;
                }
                $sr->save();
            }
        } catch (\Throwable $e) {
            // Silent fail — never break the main flow
        }
    }

    /**
     * Display a listing of job assignments.
     */
    public function index(Request $request)
    {
        $query = JobAssignment::with([
            'serviceRequest.customer',
            'serviceRequest.service',
            'technician',
        ]);

        // Search by customer name, service name, or technician name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('serviceRequest.customer', fn($c) =>
                        $c->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('serviceRequest.service', fn($s) =>
                        $s->where('service_name', 'like', "%{$search}%"))
                  ->orWhereHas('technician', fn($t) =>
                        $t->where('name', 'like', "%{$search}%"));
            });
        }

        // Status filter
        $validStatuses = ['Assigned', 'Accepted', 'In Progress', 'Completed', 'Cancelled'];
        if ($request->filled('status') && in_array($request->status, $validStatuses)) {
            $query->where('status', $request->status);
        }

        // Priority filter
        $validPriorities = ['Low', 'Medium', 'High', 'Urgent'];
        if ($request->filled('priority') && in_array($request->priority, $validPriorities)) {
            $query->where('priority', $request->priority);
        }

        $jobAssignments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.job_assignments.index', compact('jobAssignments'));
    }

    /**
     * Show the form for creating a new job assignment.
     */
    public function create()
    {
        // Show service requests that are not yet Completed/Cancelled
        $serviceRequests = ServiceRequest::with(['customer', 'service'])
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->orderBy('request_date', 'desc')
            ->get();

        $technicians = Technician::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('admin.job_assignments.create', compact('serviceRequests', 'technicians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_request_id' => ['required', 'exists:service_requests,id'],
            'technician_id'      => ['required', 'exists:technicians,id'],
            'assigned_date'      => ['required', 'date'],
            'scheduled_date'     => ['nullable', 'date', 'after_or_equal:assigned_date'],
            'scheduled_time'     => ['nullable'],
            'status'             => ['required', 'in:Assigned,Accepted,In Progress,Completed,Cancelled'],
            'priority'           => ['required', 'in:Low,Medium,High,Urgent'],
            'work_notes'         => ['nullable', 'string', 'max:5000'],
            'remarks'            => ['nullable', 'string', 'max:5000'],
        ]);

        $data = $request->all();
        if (isset($data['work_notes'])) $data['work_notes'] = trim(strip_tags($data['work_notes']));
        if (isset($data['remarks'])) $data['remarks'] = trim(strip_tags($data['remarks']));

        $job = JobAssignment::create($data);
        $this->syncServiceRequestStatus($job);

        return redirect()->route('job-assignments.index')
                         ->with('success', 'Job assignment created successfully.');
    }

    /**
     * Display the specified job assignment.
     */
    public function show(JobAssignment $jobAssignment)
    {
        $jobAssignment->load(['serviceRequest.customer', 'serviceRequest.service', 'technician']);

        return view('admin.job_assignments.show', compact('jobAssignment'));
    }

    /**
     * Show the form for editing the specified job assignment.
     */
    public function edit(JobAssignment $jobAssignment)
    {
        $serviceRequests = ServiceRequest::with(['customer', 'service'])
            ->orderBy('request_date', 'desc')
            ->get();

        $technicians = Technician::orderBy('name')->get();

        return view('admin.job_assignments.edit', compact('jobAssignment', 'serviceRequests', 'technicians'));
    }

    /**
     * Update the specified job assignment in storage.
     */
    public function update(Request $request, JobAssignment $jobAssignment)
    {
        $validated = $request->validate([
            'service_request_id' => ['required', 'exists:service_requests,id'],
            'technician_id'      => ['required', 'exists:technicians,id'],
            'assigned_date'      => ['required', 'date'],
            'scheduled_date'     => ['nullable', 'date', 'after_or_equal:assigned_date'],
            'scheduled_time'     => ['nullable'],
            'status'             => ['required', 'in:Assigned,Accepted,In Progress,Completed,Cancelled'],
            'priority'           => ['required', 'in:Low,Medium,High,Urgent'],
            'work_notes'         => ['nullable', 'string', 'max:5000'],
            'remarks'            => ['nullable', 'string', 'max:5000'],
        ]);

        $data = $request->all();
        if (isset($data['work_notes'])) $data['work_notes'] = trim(strip_tags($data['work_notes']));
        if (isset($data['remarks'])) $data['remarks'] = trim(strip_tags($data['remarks']));

        $jobAssignment->update($data);
        $this->syncServiceRequestStatus($jobAssignment->fresh());

        return redirect()->route('job-assignments.index')
                         ->with('success', 'Job assignment updated successfully.');
    }

    /**
     * Remove the specified job assignment from storage.
     */
    public function destroy(JobAssignment $jobAssignment)
    {
        try {
            if ($jobAssignment->jobStatusTrackings()->exists()) {
                return redirect()->route('job-assignments.index')->with('error', 'Cannot delete job assignment because it has active status trackings.');
            }
            $jobAssignment->delete();
            return redirect()->route('job-assignments.index')->with('success', 'Job assignment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('job-assignments.index')->with('error', 'Delete failed. Please try again.');
        }
    }
}
