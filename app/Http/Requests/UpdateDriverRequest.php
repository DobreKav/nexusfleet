<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        $driverId = $this->route('driver')?->id;

        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'license_number' => "sometimes|required|string|unique:drivers,license_number,{$driverId}",
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
