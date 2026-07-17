<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSurvey;
use App\Models\Enquiry;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class SiteSurveyController extends Controller
{
    /**
     * Display a listing of surveys.
     */
    public function index(Request $request)
    {
        $query = SiteSurvey::with(['customer', 'surveyor']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('survey_number', 'like', '%' . $search . '%')
                  ->orWhereHas('customer', function ($sub) use ($search) {
                      $sub->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhere('site_address', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Surveyor filter
        if ($request->filled('surveyor_id')) {
            $query->where('surveyor_id', $request->surveyor_id);
        }

        // Date filter range
        if ($request->filled('from_date')) {
            $query->whereDate('survey_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('survey_date', '<=', $request->to_date);
        }

        $surveys = $query->latest('id')->paginate(10)->withQueryString();
        $surveyors = User::orderBy('name')->get();

        return view('admin.site-surveys.index', compact('surveys', 'surveyors'));
    }

    /**
     * Show the form for creating a new survey.
     */
    public function create()
    {
        $enquiries = Enquiry::orderBy('enquiry_number', 'desc')->get();
        $customers = Customer::orderBy('name')->get();
        $surveyors = User::orderBy('name')->get();

        // Auto-generate unique Survey Number
        $latest = SiteSurvey::latest('id')->first();
        $nextId = $latest ? ($latest->id + 1) : 1;
        $surveyNumber = 'SURV-' . date('Ym') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('admin.site-surveys.create', compact('enquiries', 'customers', 'surveyors', 'surveyNumber'));
    }

    /**
     * Store a newly created survey in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'survey_number' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-\_]+$/', 'unique:site_surveys,survey_number'],
            'enquiry_id' => ['nullable', 'exists:enquiries,id'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'survey_date' => ['required', 'date'],
            'surveyor_id' => ['nullable', 'exists:users,id'],
            'site_address' => ['required', 'string', 'max:1000'],
            'property_type' => ['nullable', 'string', 'max:100'],
            'roof_type' => ['nullable', 'string', 'max:100'],
            'available_area' => ['nullable', 'string', 'max:100'],
            'required_solar_capacity' => ['nullable', 'string', 'max:100'],
            'existing_electricity_load' => ['nullable', 'string', 'max:100'],
            'average_electricity_bill' => ['nullable', 'string', 'max:100'],
            'meter_type' => ['nullable', 'string', 'max:100'],
            'shadow_condition' => ['nullable', 'string', 'max:100'],
            'installation_feasibility' => ['required', 'string', 'max:100'],
            'site_photos' => ['nullable', 'array'],
            'site_photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'survey_notes' => ['nullable', 'string', 'max:5000'],
            'recommendation' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:Pending,Scheduled,Completed,Approved,Rejected'],
        ]);

        $data = $request->except('site_photos');
        $data['survey_number'] = trim(strip_tags($request->survey_number));
        $data['site_address'] = trim(strip_tags($request->site_address));
        if ($request->filled('property_type')) $data['property_type'] = trim(strip_tags($request->property_type));
        if ($request->filled('roof_type')) $data['roof_type'] = trim(strip_tags($request->roof_type));
        if ($request->filled('available_area')) $data['available_area'] = trim(strip_tags($request->available_area));
        if ($request->filled('required_solar_capacity')) $data['required_solar_capacity'] = trim(strip_tags($request->required_solar_capacity));
        if ($request->filled('existing_electricity_load')) $data['existing_electricity_load'] = trim(strip_tags($request->existing_electricity_load));
        if ($request->filled('average_electricity_bill')) $data['average_electricity_bill'] = trim(strip_tags($request->average_electricity_bill));
        if ($request->filled('meter_type')) $data['meter_type'] = trim(strip_tags($request->meter_type));
        if ($request->filled('shadow_condition')) $data['shadow_condition'] = trim(strip_tags($request->shadow_condition));
        if ($request->filled('installation_feasibility')) $data['installation_feasibility'] = trim(strip_tags($request->installation_feasibility));
        if ($request->filled('survey_notes')) $data['survey_notes'] = trim(strip_tags($request->survey_notes));
        if ($request->filled('recommendation')) $data['recommendation'] = trim(strip_tags($request->recommendation));

        // Handle file uploads
        $photos = [];
        if ($request->hasFile('site_photos')) {
            foreach ($request->file('site_photos') as $photoFile) {
                $path = $photoFile->store('site_photos', 'public');
                $photos[] = $path;
            }
        }

        $data['site_photos'] = $photos;

        SiteSurvey::create($data);

        return redirect()->route('site-surveys.index')->with('success', 'Site Survey recorded successfully.');
    }

    /**
     * Display the specified survey.
     */
    public function show(string $id)
    {
        $survey = SiteSurvey::with(['customer', 'enquiry', 'surveyor'])->findOrFail($id);
        return view('admin.site-surveys.show', compact('survey'));
    }

    /**
     * Show the form for editing the specified survey.
     */
    public function edit(string $id)
    {
        $survey = SiteSurvey::findOrFail($id);
        $enquiries = Enquiry::orderBy('enquiry_number', 'desc')->get();
        $customers = Customer::orderBy('name')->get();
        $surveyors = User::orderBy('name')->get();

        return view('admin.site-surveys.edit', compact('survey', 'enquiries', 'customers', 'surveyors'));
    }

    /**
     * Update the specified survey in storage.
     */
    public function update(Request $request, string $id)
    {
        $survey = SiteSurvey::findOrFail($id);

        $validated = $request->validate([
            'survey_number' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-\_]+$/', Rule::unique('site_surveys', 'survey_number')->ignore($survey->id)],
            'enquiry_id' => ['nullable', 'exists:enquiries,id'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'survey_date' => ['required', 'date'],
            'surveyor_id' => ['nullable', 'exists:users,id'],
            'site_address' => ['required', 'string', 'max:1000'],
            'property_type' => ['nullable', 'string', 'max:100'],
            'roof_type' => ['nullable', 'string', 'max:100'],
            'available_area' => ['nullable', 'string', 'max:100'],
            'required_solar_capacity' => ['nullable', 'string', 'max:100'],
            'existing_electricity_load' => ['nullable', 'string', 'max:100'],
            'average_electricity_bill' => ['nullable', 'string', 'max:100'],
            'meter_type' => ['nullable', 'string', 'max:100'],
            'shadow_condition' => ['nullable', 'string', 'max:100'],
            'installation_feasibility' => ['required', 'string', 'max:100'],
            'site_photos' => ['nullable', 'array'],
            'site_photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'survey_notes' => ['nullable', 'string', 'max:5000'],
            'recommendation' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:Pending,Scheduled,Completed,Approved,Rejected'],
        ]);

        $data = $request->except(['site_photos', 'removed_photos']);
        $data['survey_number'] = trim(strip_tags($request->survey_number));
        $data['site_address'] = trim(strip_tags($request->site_address));
        if ($request->filled('property_type')) $data['property_type'] = trim(strip_tags($request->property_type));
        if ($request->filled('roof_type')) $data['roof_type'] = trim(strip_tags($request->roof_type));
        if ($request->filled('available_area')) $data['available_area'] = trim(strip_tags($request->available_area));
        if ($request->filled('required_solar_capacity')) $data['required_solar_capacity'] = trim(strip_tags($request->required_solar_capacity));
        if ($request->filled('existing_electricity_load')) $data['existing_electricity_load'] = trim(strip_tags($request->existing_electricity_load));
        if ($request->filled('average_electricity_bill')) $data['average_electricity_bill'] = trim(strip_tags($request->average_electricity_bill));
        if ($request->filled('meter_type')) $data['meter_type'] = trim(strip_tags($request->meter_type));
        if ($request->filled('shadow_condition')) $data['shadow_condition'] = trim(strip_tags($request->shadow_condition));
        if ($request->filled('installation_feasibility')) $data['installation_feasibility'] = trim(strip_tags($request->installation_feasibility));
        if ($request->filled('survey_notes')) $data['survey_notes'] = trim(strip_tags($request->survey_notes));
        if ($request->filled('recommendation')) $data['recommendation'] = trim(strip_tags($request->recommendation));

        $photos = $survey->site_photos ?? [];

        // Remove deleted photos
        if ($request->filled('removed_photos')) {
            $removed = json_decode($request->removed_photos, true);
            if (is_array($removed)) {
                foreach ($removed as $path) {
                    if (($key = array_search($path, $photos)) !== false) {
                        unset($photos[$key]);
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }

        // Add new photos
        if ($request->hasFile('site_photos')) {
            foreach ($request->file('site_photos') as $photoFile) {
                $path = $photoFile->store('site_photos', 'public');
                $photos[] = $path;
            }
        }

        $data['site_photos'] = array_values($photos);

        $survey->update($data);

        return redirect()->route('site-surveys.index')->with('success', 'Site Survey updated successfully.');
    }

    /**
     * Remove the specified survey.
     */
    public function destroy(string $id)
    {
        $survey = SiteSurvey::findOrFail($id);
        
        // Delete all photos from disk
        if (is_array($survey->site_photos)) {
            foreach ($survey->site_photos as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $survey->delete();

        return redirect()->route('site-surveys.index')->with('success', 'Site Survey deleted successfully.');
    }
}
