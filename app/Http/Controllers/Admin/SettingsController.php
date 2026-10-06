<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function edit()
    {
        $this->authorizeSettingsAccess();
        $settings = CompanySetting::firstOrCreate(['id' => 1], ['company_name' => 'Gayatri Solar Energy']);

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorizeSettingsAccess();
        $settings = CompanySetting::firstOrCreate(['id' => 1], ['company_name' => 'Gayatri Solar Energy']);
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'regex:/^[6-9][0-9]{9}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'gst_number' => ['nullable', 'regex:/^[0-9A-Z]{15}$/'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($settings->logo) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $request->file('logo')->store('company', 'public');
        }

        $settings->update($data);

        return redirect()->route('settings.edit')->with('success', 'Company settings updated successfully.');
    }

    private function authorizeSettingsAccess(): void
    {
        $user = auth()->user();
        $isAdmin = in_array($user->role, ['Admin', 'Super Admin'], true)
            || $user->hasRole('Admin')
            || $user->hasRole('Super Admin');

        abort_unless($isAdmin, 403);
    }
}