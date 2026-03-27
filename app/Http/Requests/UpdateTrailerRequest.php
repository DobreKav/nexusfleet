<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrailerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        $trailerId = $this->route('trailer')?->id;

        return [
            'plate_number' => "sometimes|required|string|unique:trailers,plate_number,{$trailerId}",
            'type' => 'sometimes|required|string',
            'payload_capacity' => 'sometimes|required|integer|min:1',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
