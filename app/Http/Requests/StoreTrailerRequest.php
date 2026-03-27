<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrailerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'plate_number' => 'required|string|unique:trailers,plate_number',
            'type' => 'required|string',
            'payload_capacity' => 'required|integer|min:1',
            'status' => 'nullable|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'plate_number.required' => __('Регистарската табла е задолжителна'),
            'plate_number.unique' => __('Оваа регистарска табла веќе постои'),
            'type.required' => __('Типот на приколка е задолжителен'),
            'payload_capacity.required' => __('Капацитетот е задолжителен'),
        ];
    }
}
