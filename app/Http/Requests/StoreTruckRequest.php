<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTruckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'plate_number' => 'required|string|unique:trucks,plate_number',
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|digits:4|integer',
            'current_odometer' => 'nullable|integer|min:0',
            'service_interval_km' => 'nullable|integer|min:1000',
            'cost_per_km' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:active,inactive,maintenance',
        ];
    }

    public function messages(): array
    {
        return [
            'plate_number.required' => __('Регистарската табла е задолжителна'),
            'plate_number.unique' => __('Оваа регистарска табла веќе постои'),
            'brand.required' => __('Марката е задолжителна'),
            'model.required' => __('Моделот е задолжителен'),
            'year.required' => __('Годината е задолжителна'),
        ];
    }
}
