<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobStatusTracking;
use App\Models\JobAssignment;
use Illuminate\Http\Request;

class JobStatusTrackingController extends Controller
{
    /* ─────────────────────────────────────────────────
       Sync job_assignment + service_request statuses
    ───────────────────────────────────────────────── */
    private function syncUpstream(JobStatusTracking $track): void
    {
        try {
            $job = $track->jobAssignment;
            if (!$job) return;

            /* Map tracking status → job_assignment status (only use valid enum values) */
            $jobStatusMap = [
                'Assigned'    => 'Assigned',
                'Accepted'    => 'Accepted',
                'On The Way'  => 'Assigned',   // closest valid job status
                'In Progress' => 'In Progress',
                'Hold'        => 'Assigned',   // keep job "Assigned" when on hold
                'Completed'   => 'Completed',
                'Cancelled'   => 'Cancelled',
            ];

            $newJobStatus = $jobStatusMap[$track->status] ?? null;
            if ($newJobStatus && $job->status !== $newJobStatus) {
                $job->status = $newJobStatus;
                $job->save();
            }

            /* Map tracking status → service_request status */
            $srStatusMap = [
                'Assigned'    => 'Assigned',
                'Accepted'    => 'Assigned',
                'On The Way'  => 'Assigned',
                'In Progress' => 'In Progress',
                'Hold'        => 'In Progress',
                'Completed'   => 'Completed',
                'Cancelled'   => 'Cancelled',
            ];

            $sr = $job->serviceRequest;
            if ($sr) {
                $newSrStatus = $srStatusMap[$track->status] ?? null;
                if ($newSrStatus && $sr->status !== $newSrStatus) {
                    $sr->status = $newSrStatus;
                    $sr->save();
                }
            }
        } catch (\Throwable $e) {
            // Silent fail — never break the main flow
        }
    }

    /* ─────────────────────────────────────────────────
       CRUD
    ───────────────────────────────────────────────── */

    public function index(Request $request)
    {
        $query = JobStatusTracking::with([
            'jobAssignment.serviceRequest.customer',
            'jobAssignment.serviceRequest.service',
            'jobAssignment.technician',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('status', 'like', "%{$search}%")
                  ->orWhereHas('jobAssignment.serviceRequest.customer',
                        fn($c) => $c->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('jobAssignment.serviceRequest.service',
                        fn($s) => $s->where('service_name', 'like', "%{$search}%"))
                  ->orWhereHas('jobAssignment.technician',
                        fn($t) => $t->where('name', 'like', "%{$search}%"));
            });
        }

        $validStatuses = ['Assigned','Accepted','On The Way','In Progress','Hold','Completed','Cancelled'];
        if ($request->filled('status') && in_array($request->status, $validStatuses)) {
            $query->where('status', $request->status);
        }

        $trackings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.job_status_trackings.index', compact('trackings'));
    }

    public function create()
    {
        $jobAssignments = JobAssignment::with([
            'serviceRequest.customer',
            'serviceRequest.service',
            'technician',
        ])->orderBy('assigned_date', 'desc')->get();

        return view('admin.job_status_trackings.create', compact('jobAssignments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_assignment_id' => 'required|exists:job_assignments,id',
            'status'            => 'required|in:Assigned,Accepted,On The Way,In Progress,Hold,Completed,Cancelled',
            'status_date'       => 'required|date',
            'status_time'       => 'nullable',
            'work_progress'     => 'nullable|string',
            'notes'             => 'nullable|string',
        ]);

        $track = JobStatusTracking::create($request->all());
        $this->syncUpstream($track);

        return redirect()->route('job-status-tracking.index')
                         ->with('success', 'Job status tracking record created successfully.');
    }

    public function show(JobStatusTracking $jobStatusTracking)
    {
        $jobStatusTracking->load([
            'jobAssignment.serviceRequest.customer',
            'jobAssignment.serviceRequest.service',
            'jobAssignment.technician',
        ]);

        return view('admin.job_status_trackings.show', compact('jobStatusTracking'));
    }

    public function edit(JobStatusTracking $jobStatusTracking)
    {
        $jobAssignments = JobAssignment::with([
            'serviceRequest.customer',
            'serviceRequest.service',
            'technician',
        ])->orderBy('assigned_date', 'desc')->get();

        return view('admin.job_status_trackings.edit', compact('jobStatusTracking', 'jobAssignments'));
    }

    public function update(Request $request, JobStatusTracking $jobStatusTracking)
    {
        $request->validate([
            'job_assignment_id' => 'required|exists:job_assignments,id',
            'status'            => 'required|in:Assigned,Accepted,On The Way,In Progress,Hold,Completed,Cancelled',
            'status_date'       => 'required|date',
            'status_time'       => 'nullable',
            'work_progress'     => 'nullable|string',
            'notes'             => 'nullable|string',
        ]);

        $jobStatusTracking->update($request->all());
        $this->syncUpstream($jobStatusTracking->fresh());

        return redirect()->route('job-status-tracking.index')
                         ->with('success', 'Job status tracking record updated successfully.');
    }

    public function destroy(JobStatusTracking $jobStatusTracking)
    {
        try {
            $jobStatusTracking->delete();
            return redirect()->route('job-status-tracking.index')->with('success', 'Record deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('job-status-tracking.index')->with('error', 'This record is linked with other data and cannot be deleted.');
        }
    }
}
