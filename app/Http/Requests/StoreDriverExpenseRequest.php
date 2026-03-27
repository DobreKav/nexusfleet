<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'driver_id' => 'required|exists:drivers,id',
            'tour_id' => 'nullable|exists:tours,id',
            'type' => 'required|in:fuel,toll,vignette,maintenance,other',
            'amount' => 'required|numeric|min:0',
            'odometer_reading' => 'nullable|integer|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'driver_id.required' => __('Возачот е задолжителен'),
            'type.required' => __('Типот е задолжителен'),
            'amount.required' => __('Износот е задолжителен'),
            'expense_date.required' => __('Датумот е задолжителен'),
        ];
    }
}
