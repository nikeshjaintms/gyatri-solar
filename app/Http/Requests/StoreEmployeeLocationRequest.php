<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        if ($this->has('locations') && is_array($this->input('locations'))) {
            return [
                'locations' => ['required', 'array', 'min:1', 'max:100'],
                'locations.*.latitude' => ['required', 'numeric', 'between:-90,90'],
                'locations.*.longitude' => ['required', 'numeric', 'between:-180,180'],
                'locations.*.accuracy' => ['nullable', 'numeric', 'min:0', 'max:50000'],
                'locations.*.speed' => ['nullable', 'numeric', 'min:0', 'max:500'],
                'locations.*.battery_level' => ['nullable', 'integer', 'between:0,100'],
                'locations.*.tracked_at' => ['nullable', 'date'],
                'locations.*.device_id' => ['nullable', 'string', 'max:191'],
                'locations.*.sync_id' => ['nullable', 'string', 'max:100'],
            ];
        }

        return [
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0', 'max:50000'],
            'speed' => ['nullable', 'numeric', 'min:0', 'max:500'],
            'battery_level' => ['nullable', 'integer', 'between:0,100'],
            'tracked_at' => ['nullable', 'date'],
            'device_id' => ['nullable', 'string', 'max:191'],
            'sync_id' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required' => 'Latitude is required.',
            'latitude.between' => 'Latitude must be between -90 and +90 degrees.',
            'longitude.required' => 'Longitude is required.',
            'longitude.between' => 'Longitude must be between -180 and +180 degrees.',
            'battery_level.between' => 'Battery percentage must be between 0 and 100.',
            'locations.*.latitude.between' => 'Location latitude must be between -90 and +90 degrees.',
            'locations.*.longitude.between' => 'Location longitude must be between -180 and +180 degrees.',
            'locations.*.battery_level.between' => 'Battery percentage must be between 0 and 100.',
        ];
    }
}
