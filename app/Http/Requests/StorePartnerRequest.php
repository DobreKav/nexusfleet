<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'tax_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'type' => 'required|in:supplier,client,both',
            'status' => 'nullable|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Името на партнерот е задолжително'),
            'type.required' => __('Типот е задолжителен'),
        ];
    }
}
