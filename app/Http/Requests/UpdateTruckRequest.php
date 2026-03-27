<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTruckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        $truckId = $this->route('truck')?->id;

        return [
            'plate_number' => "sometimes|required|string|unique:trucks,plate_number,{$truckId}",
            'brand' => 'sometimes|required|string',
            'model' => 'sometimes|required|string',
            'year' => 'sometimes|required|digits:4|integer',
            'current_odometer' => 'nullable|integer|min:0',
            'service_interval_km' => 'nullable|integer|min:1000',
            'cost_per_km' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:active,inactive,maintenance',
        ];
    }
}
