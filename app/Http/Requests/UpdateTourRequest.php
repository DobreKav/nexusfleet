<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'truck_id' => 'sometimes|required|exists:trucks,id',
            'trailer_id' => 'nullable|exists:trailers,id',
            'driver_id' => 'sometimes|required|exists:drivers,id',
            'partner_id' => 'nullable|exists:partners,id',
            'start_location' => 'sometimes|required|string|max:255',
            'end_location' => 'sometimes|required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'total_km' => 'nullable|integer|min:0',
            'cost_per_km' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:planned,in-progress,completed',
        ];
    }
}
