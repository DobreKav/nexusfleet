<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverExpenseForTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isDriver();
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:fuel,toll,vignette,maintenance,other',
            'amount' => 'required|numeric|min:0.01',
            'odometer_reading' => 'nullable|integer|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => __('Типот е задолжителен'),
            'type.in' => __('Невалиден тип'),
            'amount.required' => __('Износот е задолжителен'),
            'amount.numeric' => __('Износот мора да биде број'),
            'amount.min' => __('Износот не може да биде 0'),
            'expense_date.required' => __('Датумот е задолжителен'),
            'expense_date.date' => __('Невалиден датум формат'),
        ];
    }
}
