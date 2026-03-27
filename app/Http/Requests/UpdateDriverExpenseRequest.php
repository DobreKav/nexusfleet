<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'driver_id' => 'sometimes|required|exists:drivers,id',
            'tour_id' => 'nullable|exists:tours,id',
            'type' => 'sometimes|required|in:fuel,toll,vignette,maintenance,other',
            'amount' => 'sometimes|required|numeric|min:0',
            'odometer_reading' => 'nullable|integer|min:0',
            'expense_date' => 'nullable|date',
            'description' => 'nullable|string',
        ];
    }
}
